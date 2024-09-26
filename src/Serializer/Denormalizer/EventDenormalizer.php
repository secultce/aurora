<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\Event;
use App\Entity\Initiative;
use App\Entity\Space;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class EventDenormalizer implements DenormalizerInterface
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

        if (Event::class !== $type) {
            return $data;
        }

        /* @var Event $event */
        $event = $this->denormalizer->denormalize($data, Event::class, $format, $context);

        if (isset($data['agentGroup'])) {
            $data['agentGroup'] = $this->entityManager->getRepository(Agent::class)->find($data['agentGroup']);
            $event->setAgentGroup($data['agentGroup']);
        }

        if (isset($data['space'])) {
            $data['space'] = $this->entityManager->getRepository(Space::class)->find($data['space']);
            $event->setSpace($data['space']);
        }

        if (isset($data['initiative'])) {
            $data['initiative'] = $this->entityManager->getRepository(Initiative::class)->find($data['initiative']);
            $event->setInitiative($data['initiative']);
        }

        if (isset($data['parent'])) {
            $data['parent'] = $this->entityManager->getRepository(Event::class)->find($data['parent']);
            $event->setParent($data['parent']);
        }

        if (isset($data['createdBy'])) {
            $data['createdBy'] = $this->entityManager->getRepository(Agent::class)->find($data['createdBy']);
            $event->setCreatedBy($data['createdBy']);
        }

        return $event;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Event::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            Event::class => true,
        ];
    }
}
