<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\Organization;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class AgentDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Autowire(service: 'serializer.normalizer.object')]
        private DenormalizerInterface $denormalizer,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (false === is_array($data)) {
            return $this->denormalizer->denormalize(['id' => $data], $type, $format, $context);
        }

        if (Agent::class !== $type) {
            return $data;
        }

        $organizations = array_map(
            fn (string $id) => $this->entityManager->getRepository(Organization::class)->findOneBy(['id' => $id]),
            $data['organizations'] ?? []
        );

        /* @var Agent $agent */
        $agent = $this->denormalizer->denormalize($this->filterData($data), $type, $format, $context);

        if (true === array_key_exists('organizations', $data)) {
            $agent->setOrganizations(new ArrayCollection($organizations));
        }

        return $agent;
    }

    private function filterData(array $data): array
    {
        unset($data['organizations']);

        return $data;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Agent::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            Agent::class => true,
        ];
    }
}
