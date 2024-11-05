<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\Event;
use App\Entity\Initiative;
use App\Entity\Opportunity;
use App\Entity\Space;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class OpportunityDenormalizer implements DenormalizerInterface
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

        if (Opportunity::class !== $type) {
            return $data;
        }

        /** @var Opportunity $opportunity */
        $opportunity = $this->denormalizer->denormalize($this->filterData($data), $type, $format, $context);

        if (true === array_key_exists('parent', $data)) {
            $parent = (null !== $data['parent']) ? $this->entityManager->getRepository(Opportunity::class)->find($data['parent']) : null;
            $opportunity->setParent($parent);
        }

        if (true === array_key_exists('space', $data)) {
            $space = (null !== $data['space']) ? $this->entityManager->getRepository(Space::class)->find($data['space']) : null;
            $opportunity->setSpace($space);
        }

        if (true === array_key_exists('initiative', $data)) {
            $initiative = (null !== $data['initiative']) ? $this->entityManager->getRepository(Initiative::class)->find($data['initiative']) : null;
            $opportunity->setInitiative($initiative);
        }

        if (true === array_key_exists('event', $data)) {
            $event = (null !== $data['event']) ? $this->entityManager->getRepository(Event::class)->find($data['event']) : null;
            $opportunity->setEvent($event);
        }

        if (true === array_key_exists('createdBy', $data)) {
            $createdBy = $this->entityManager->getRepository(Agent::class)->find($data['createdBy']);
            $opportunity->setCreatedBy($createdBy);
        }

        return $opportunity;
    }

    private function filterData(array $data): array
    {
        unset($data['parent']);

        return $data;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Opportunity::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            Opportunity::class => true,
        ];
    }
}
