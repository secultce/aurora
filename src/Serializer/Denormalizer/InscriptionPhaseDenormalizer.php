<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\InscriptionPhase;
use App\Entity\Phase;
use App\Enum\InscriptionPhaseStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class InscriptionPhaseDenormalizer implements DenormalizerInterface
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

        if (InscriptionPhase::class !== $type) {
            return $data;
        }

        if (true === array_key_exists('status', $data)) {
            $this->denormalizeInscriptionPhaseStatus($data);
        }

        /** @var InscriptionPhase $inscriptionPhase */
        $inscriptionPhase = $this->denormalizer->denormalize($data, $type, $format, $context);

        if (true === array_key_exists('phase', $data)) {
            $phase = (null !== $data['phase']) ? $this->entityManager->getRepository(Phase::class)->find($data['phase']) : null;
            $inscriptionPhase->setPhase($phase);
        }

        if (true === array_key_exists('agent', $data)) {
            $agent = $this->entityManager->getRepository(Agent::class)->find($data['agent']);
            $inscriptionPhase->setAgent($agent);
        }

        return $inscriptionPhase;
    }

    private function denormalizeInscriptionPhaseStatus(array &$data): void
    {
        if (true === is_string($data['status'])) {
            $data['status'] = InscriptionPhaseStatusEnum::fromName($data['status']);
        }

        if ($data['status'] instanceof InscriptionPhaseStatusEnum) {
            $data['status'] = $data['status']->value;
        }
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return InscriptionPhase::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            InscriptionPhase::class => true,
        ];
    }
}
