<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Address;
use App\Entity\Agent;
use App\Entity\AgentAddress;
use App\Entity\City;
use App\Entity\Space;
use App\Entity\SpaceAddress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class AddressDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Autowire(service: 'serializer.normalizer.object')]
        private DenormalizerInterface $denormalizer,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (isset($data['ownerType']) && 'agent' === $data['ownerType']) {
            $type = AgentAddress::class;
        } elseif (isset($data['ownerType']) && 'space' === $data['ownerType']) {
            $type = SpaceAddress::class;
        }

        if (false === is_array($data)) {
            return $this->denormalizer->denormalize(['id' => $data], $type, $format, $context);
        }

        if (false === $this->supportsDenormalization($data, $type, $format, $context)) {
            return $data;
        }

        /** @var Address $address */
        $address = $this->denormalizer->denormalize($data, $type, $format, $context);

        if (isset($data['owner']) && isset($data['ownerType'])) {
            if ('agent' === $data['ownerType']) {
                $data['owner'] = $this->entityManager->getRepository(Agent::class)->find($data['owner']);
            } elseif ('space' === $data['ownerType']) {
                $data['owner'] = $this->entityManager->getRepository(Space::class)->find($data['owner']);
            }
            $address->owner = $data['owner'];
        }

        if (isset($data['city'])) {
            $data['city'] = $this->entityManager->getRepository(City::class)->find($data['city']);
            $address->city = $data['city'];
        }

        return $address;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return in_array($type, [SpaceAddress::class, AgentAddress::class, Address::class]);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            Address::class => true,
        ];
    }
}
