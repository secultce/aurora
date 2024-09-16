<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\Organization;
use Doctrine\Common\Collections\ArrayCollection;
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

        $agents = array_map(
            fn (string $id) => $this->entityManager->getRepository(Agent::class)->findOneBy(['id' => $id]),
            $data['agents'] ?? []
        );

        /* @var Organization $organization */
        $organization = $this->denormalizer->denormalize($this->filterData($data), $type, $format, $context);

        if (true === array_key_exists('agents', $data)) {
            $organization->setAgents(new ArrayCollection($agents));
        }

        if (true === array_key_exists('createdBy', $data)) {
            $createdBy = $this->entityManager->getRepository(Agent::class)->find($data['createdBy']);
            $organization->setCreatedBy($createdBy);
        }

        if (true === array_key_exists('owner', $data)) {
            $owner = $this->entityManager->getRepository(Agent::class)->find($data['owner']);
            $organization->setOwner($owner);
        }

        return $organization;
    }

    private function filterData(array $data): array
    {
        unset($data['agents']);

        return $data;
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
