<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\Space;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class SpaceDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Autowire(service: 'serializer.normalizer.object')]
        private DenormalizerInterface $denormalizer,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (Space::class !== $type) {
            return $data;
        }

        $space = $this->denormalizer->denormalize($data, $type, $format, $context);

        if (isset($data['createdBy'])) {
            $data['createdBy'] = $this->entityManager->getRepository(Agent::class)->find($data['createdBy']);
            $space->setCreatedBy($data['createdBy']);
        }

        if (isset($data['parent'])) {
            $data['parent'] = $this->entityManager->getRepository(Space::class)->find($data['parent']);
            $space->setParent($data['parent']);
        }

        return $space;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Space::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            Space::class => true,
        ];
    }
}
