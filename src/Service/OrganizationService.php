<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\OrganizationDto;
use App\Entity\Organization;
use App\Exception\Organization\OrganizationResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\OrganizationRepositoryInterface;
use App\Service\Interface\FileServiceInterface;
use App\Service\Interface\OrganizationServiceInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class OrganizationService extends AbstractEntityService implements OrganizationServiceInterface
{
    private const string DIR_ORGANIZATION_PROFILE = 'app.dir.organization.profile';

    public function __construct(
        private FileServiceInterface $fileService,
        private ParameterBagInterface $parameterBag,
        private OrganizationRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct(
            $this->security,
            $this->serializer,
            $this->validator,
            $this->entityManager,
            Organization::class,
            $this->fileService,
            $this->parameterBag,
            self::DIR_ORGANIZATION_PROFILE,
        );
    }

    public function count(): int
    {
        return $this->repository->count(
            $this->getDefaultParams()
        );
    }

    public function create(array $organization): Organization
    {
        $organization = $this->validateInput($organization, OrganizationDto::class, OrganizationDto::CREATE);

        $organizationObj = $this->serializer->denormalize($organization, Organization::class);

        return $this->repository->save($organizationObj);
    }

    public function findBy(array $params = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getUserParams()],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function findOneBy(array $params): ?Organization
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
    }

    public function get(Uuid $id): Organization
    {
        $organization = $this->repository->findOneBy([
            ...['id' => $id],
            ...$this->getDefaultParams(),
        ]);

        if (null === $organization) {
            throw new OrganizationResourceNotFoundException();
        }

        return $organization;
    }

    public function list(int $limit = 50, array $params = [], string $order = 'DESC'): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getDefaultParams()],
            ['createdAt' => $order],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $organization = $this->findOneBy(
            [...['id' => $id], ...$this->getUserParams()]
        );

        if (null === $organization) {
            throw new OrganizationResourceNotFoundException();
        }

        $organization->setDeletedAt(new DateTime());

        if ($organization->getImage()) {
            $this->fileService->deleteFileByUrl($organization->getImage());
        }

        $this->repository->save($organization);
    }

    public function update(Uuid $identifier, array $organization): Organization
    {
        $organizationFromDB = $this->get($identifier);

        $organizationDto = $this->validateInput($organization, OrganizationDto::class, OrganizationDto::UPDATE);

        $organizationObj = $this->serializer->denormalize($organizationDto, Organization::class, context: [
            'object_to_populate' => $organizationFromDB,
        ]);

        $organizationObj->setUpdatedAt(new DateTime());

        return $this->repository->save($organizationObj);
    }

    public function updateImage(Uuid $id, UploadedFile $uploadedFile): Organization
    {
        $organization = $this->get($id);

        $organizationDto = new OrganizationDto();
        $organizationDto->image = $uploadedFile;

        $violations = $this->validator->validate($organizationDto, groups: [OrganizationDto::UPDATE]);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        if ($organization->getImage()) {
            $this->fileService->deleteFileByUrl($organization->getImage());
        }

        $uploadedImage = $this->fileService->uploadImage(
            $this->parameterBag->get(self::DIR_ORGANIZATION_PROFILE),
            $uploadedFile
        );

        $organization->setImage($this->fileService->urlOfImage($uploadedImage->getFilename()));

        $organization->setUpdatedAt(new DateTime());

        $this->repository->save($organization);

        return $organization;
    }
}
