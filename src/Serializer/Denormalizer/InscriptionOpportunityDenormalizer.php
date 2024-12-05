<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\InscriptionOpportunity;
use App\Entity\Opportunity;
use App\Enum\InscriptionOpportunityStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class InscriptionOpportunityDenormalizer implements DenormalizerInterface
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

        if (InscriptionOpportunity::class !== $type) {
            return $data;
        }

        if (true === array_key_exists('status', $data)) {
            $this->denormalizeInscriptionOpportunityStatus($data);
        }

        /** @var InscriptionOpportunity $inscriptionOpportunity */
        $inscriptionOpportunity = $this->denormalizer->denormalize($data, $type, $format, $context);

        if (true === array_key_exists('opportunity', $data)) {
            $opportunity = (null !== $data['opportunity']) ? $this->entityManager->getRepository(Opportunity::class)->find($data['opportunity']) : null;
            $inscriptionOpportunity->setOpportunity($opportunity);
        }

        if (true === array_key_exists('agent', $data)) {
            $agent = $this->entityManager->getRepository(Agent::class)->find($data['agent']);
            $inscriptionOpportunity->setAgent($agent);
        }

        return $inscriptionOpportunity;
    }

    private function denormalizeInscriptionOpportunityStatus(array &$data): void
    {
        if (true === is_string($data['status'])) {
            $data['status'] = InscriptionOpportunityStatusEnum::fromName($data['status']);
        }

        if ($data['status'] instanceof InscriptionOpportunityStatusEnum) {
            $data['status'] = $data['status']->value;
        }
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return InscriptionOpportunity::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            InscriptionOpportunity::class => true,
        ];
    }
}
