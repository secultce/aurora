<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\Initiative;
use App\Entity\Space;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class InitiativeDenormalize implements DenormalizerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Autowire(service: 'serializer.normalizer.object')]
        private DenormalizerInterface $denormalizer,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (Initiative::class !== $type) {
            return $data;
        }

        $initiative = $this->denormalizer->denormalize($data, $type, $format, $context);

        if (isset($data['createdBy'])) {
            $data['createdBy'] = $this->entityManager->getRepository(Agent::class)->find($data['createdBy']);
            $initiative->setCreatedBy($data['createdBy']);
        }

        if (isset($data['parent'])) {
            $data['parent'] = $this->entityManager->getRepository(Initiative::class)->find($data['parent']);
            $initiative->setParent($data['parent']);
        }

        if (isset($data['space'])) {
            $data['space'] = $this->entityManager->getRepository(Space::class)->find($data['space']);
            $initiative->setSpace($data['space']);
        }

        return $initiative;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Initiative::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            Initiative::class => true,
        ];
    }
}
