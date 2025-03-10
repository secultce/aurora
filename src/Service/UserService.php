<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\UserDto;
use App\Entity\User;
use App\Exception\User\UserResourceNotFoundException;
use App\Repository\Interface\UserRepositoryInterface;
use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\FileServiceInterface;
use App\Service\Interface\UserServiceInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserService extends AbstractEntityService implements UserServiceInterface
{
    private const string DIR_USER_PROFILE = 'app.dir.user.profile';

    public function __construct(
        private AgentServiceInterface $agentService,
        private UserRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private FileServiceInterface $fileService,
        private ParameterBagInterface $parameterBag,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
        private PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
        parent::__construct(
            $this->security,
            $this->serializer,
            $this->validator,
            $this->entityManager,
            User::class,
            $this->fileService,
            $this->parameterBag,
            self::DIR_USER_PROFILE,
        );
    }

    public function create(array $user): User
    {
        $user = $this->validateInput($user, UserDto::class, UserDto::CREATE);

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

    public function findAll(): array
    {
        return $this->repository->findAll();
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

        $user = $this->validateInput($user, UserDto::class, UserDto::UPDATE);

        $userObj = $this->serializer->denormalize($user, User::class, context: [
            'object_to_populate' => $userObj,
        ]);

        $userObj->setUpdatedAt(new DateTime());

        return $this->repository->save($userObj);
    }
}
