<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\AddressDto;
use App\Entity\Address;
use App\Exception\ValidatorException;
use App\Repository\AddressRepository;
use App\Service\Interface\AddressServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class AddressService extends AbstractEntityService implements AddressServiceInterface
{
    public function __construct(
        private AddressRepository $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security);
    }

    public function create(array $address): Address
    {
        $address = self::validateInput($address, AddressDto::CREATE);

        $address = $this->serializer->denormalize($address, Address::class);

        return $this->repository->save($address);
    }

    public function update(Uuid $id, array $address): Address
    {
        $address = self::validateInput($address, AddressDto::UPDATE);

        $address = $this->serializer->denormalize($address, Address::class);

        return $this->repository->save($address);
    }

    private function denormalizeDto(array $data): AddressDto
    {
        return $this->serializer->denormalize($data, AddressDto::class);
    }

    private function validateInput(array $address, string $group): array
    {
        $addressDto = self::denormalizeDto($address);

        $violations = $this->validator->validate($addressDto, groups: $group);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        return $address;
    }
}
