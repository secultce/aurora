<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\UserDto;
use App\Entity\User;
use App\Exception\User\UserResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\UserRepositoryInterface;
use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\FileServiceInterface;
use App\Service\Interface\UserServiceInterface;
use DateTime;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserService implements UserServiceInterface
{
    private const array DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private AgentServiceInterface $agentService,
        private UserRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private FileServiceInterface $fileService,
        private ParameterBagInterface $parameterBag,
        private ValidatorInterface $validator,
        private PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function create(array $user): User
    {
        $user = self::validateInput($user, UserDto::CREATE);

        $password = $this->passwordHasherFactory->getPasswordHasher(User::class)->hash($user['password']);

        $userObj = $this->serializer->denormalize($user, User::class);
        $userObj->setPassword($password);

        try {
            $this->repository->beginTransaction();
            $this->repository->save($userObj);
            $this->repository->commit();

            $this->agentService->createFromUser($user);
        } catch (Exception $exception) {
            $this->repository->rollback();
            throw $exception;
        }

        return $userObj;
    }

    public function get(Uuid $id): User
    {
        $user = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $user) {
            throw new UserResourceNotFoundException();
        }

        return $user;
    }

    public function update(Uuid $id, array $user): User
    {
        $userObj = $this->get($id);

        $user = self::validateInput($user, UserDto::UPDATE);

        $userObj = $this->serializer->denormalize($user, User::class, context: [
            'object_to_populate' => $userObj,
        ]);

        $userObj->setUpdatedAt(new DateTime());

        return $this->repository->save($userObj);
    }

    private function validateInput(array $user, string $group): array
    {
        $userDto = self::denormalizeDto($user);

        $violations = $this->validator->validate($userDto, groups: $group);

        if ($violations->count() > 0) {
            if ($userDto->image instanceof File) {
                $this->fileService->deleteFile($userDto->image->getRealPath());
            }
            throw new ValidatorException(violations: $violations);
        }

        if ($userDto->image instanceof File) {
            $user = array_merge($user, ['image' => $userDto->image]);
        }

        return $user;
    }

    private function denormalizeDto(array $data): UserDto
    {
        return $this->serializer->denormalize($data, UserDto::class, context: [
            AbstractNormalizer::CALLBACKS => [
                'image' => function () use ($data): ?File {
                    if (false === isset($data['image'])) {
                        return null;
                    }

                    return $this->fileService->uploadImage($this->parameterBag->get('app.dir.user.profile'), $data['image']);
                },
            ],
        ]);
    }
}
