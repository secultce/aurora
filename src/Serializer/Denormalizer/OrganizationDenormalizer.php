<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class OrganizationDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Autowire(service: 'serializer.normalizer.object')]
        private DenormalizerInterface $denormalizer,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (Organization::class !== $type) {
            return $data;
        }

        $agents = $data['agents'] ?? [];
        unset($data['agents']);

        $organization = $this->denormalizer->denormalize($data, $type, $format, $context);

        foreach ($agents as $id) {
            $agent = $this->entityManager->getRepository(Agent::class)->findOneBy(['id' => $id]);
            $organization->addAgent($agent);
        }

        if (isset($data['createdBy'])) {
            $data['createdBy'] = $this->entityManager->getRepository(Agent::class)->find($data['createdBy']);
            $organization->setCreatedBy($data['createdBy']);
        }

        if (isset($data['owner'])) {
            $data['owner'] = $this->entityManager->getRepository(Agent::class)->find($data['owner']);
            $organization->setOwner($data['owner']);
        }

        return $organization;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Organization::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            Organization::class => true,
        ];
    }
}
