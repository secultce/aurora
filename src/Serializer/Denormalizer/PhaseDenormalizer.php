<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\Opportunity;
use App\Entity\Phase;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class PhaseDenormalizer implements DenormalizerInterface
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

        if (Phase::class !== $type) {
            return $data;
        }

        /** @var Phase $phase */
        $phase = $this->denormalizer->denormalize($data, $type, $format, $context);

        if (true === array_key_exists('createdBy', $data)) {
            $data['createdBy'] = $this->entityManager->getRepository(Agent::class)->find($data['createdBy']);
            $phase->setCreatedBy($data['createdBy']);
        }

        if (true === array_key_exists('opportunity', $data)) {
            $data['opportunity'] = $this->entityManager->getRepository(Opportunity::class)->find($data['opportunity']);
            $phase->setOpportunity($data['opportunity']);
        }

        $reviewers = array_map(
            fn (string $id) => $this->entityManager->getRepository(Agent::class)->findOneBy(['id' => $id]),
            $data['reviewers'] ?? []
        );

        if (true === array_key_exists('reviewers', $data)) {
            $phase->setReviewers(new ArrayCollection($reviewers));
        }

        return $phase;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Phase::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            Phase::class => true,
        ];
    }
}
