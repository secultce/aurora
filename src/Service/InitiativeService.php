<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\InitiativeDto;
use App\Entity\Agent;
use App\Entity\Initiative;
use App\Exception\Initiative\InitiativeResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\InitiativeRepositoryInterface;
use App\Service\Interface\FileServiceInterface;
use App\Service\Interface\InitiativeServiceInterface;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class InitiativeService extends AbstractEntityService implements InitiativeServiceInterface
{
    public function __construct(
        private FileServiceInterface $fileService,
        private ParameterBagInterface $parameterBag,
        private InitiativeRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security);
    }

    public function count(?Agent $createdBy = null): int
    {
        $criteria = $this->getDefaultParams();

        if ($createdBy) {
            $criteria['createdBy'] = $createdBy;
        }

        return $this->repository->count($criteria);
    }

    public function create(array $initiative): Initiative|ConstraintViolationList
    {
        $initiative = self::validateInput($initiative, InitiativeDto::CREATE);

        $initiativeObj = $this->serializer->denormalize($initiative, Initiative::class);

        return $this->repository->save($initiativeObj);
    }

    private function denormalizeDto(array $data): InitiativeDto
    {
        return $this->serializer->denormalize($data, InitiativeDto::class, context: [
            AbstractNormalizer::CALLBACKS => [
                'image' => function () use ($data) {
                    if (false === isset($data['image'])) {
                        return null;
                    }

                    return $this->fileService->uploadImage($this->parameterBag->get('app.dir.initiative.profile'), $data['image']);
                },
            ],
        ]);
    }

    public function findBy(array $params = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getUserParams()],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function findOneBy(array $params): Initiative
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
    }

    public function get(Uuid $id): Initiative
    {
        $initiative = $this->repository->findOneBy([
            ...['id' => $id],
            ...$this->getDefaultParams(),
        ]);

        if (null === $initiative) {
            throw new InitiativeResourceNotFoundException();
        }

        return $initiative;
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
        $initiative = $this->get($id);
        $initiative->setDeletedAt(new DateTime());

        $this->repository->save($initiative);
    }

    public function update(Uuid $id, array $initiative): Initiative
    {
        $initiativeFromDB = $this->get($id);

        $initiativeDto = self::validateInput($initiative, InitiativeDto::UPDATE);

        $initiativeObj = $this->serializer->denormalize($initiativeDto, Initiative::class, context: [
            'object_to_populate' => $initiativeFromDB,
        ]);

        $initiativeObj->setUpdatedAt(new DateTime());

        return $this->repository->save($initiativeObj);
    }

    public function updateImage(Uuid $id, UploadedFile $uploadedFile): Initiative
    {
        $initiative = $this->get($id);

        $initiativeDto = new InitiativeDto();
        $initiativeDto->image = $uploadedFile;

        $violations = $this->validator->validate($initiativeDto, groups: [InitiativeDto::UPDATE]);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        if ($initiative->getImage()) {
            $this->fileService->deleteFileByUrl($initiative->getImage());
        }

        $uploadedImage = $this->fileService->uploadImage(
            $this->parameterBag->get('app.dir.initiative.profile'),
            $uploadedFile
        );

        $initiative->setImage($this->fileService->urlOfImage($uploadedImage->getFilename()));

        $initiative->setUpdatedAt(new DateTime());

        $this->repository->save($initiative);

        return $initiative;
    }

    private function validateInput(array $initiative, string $group): array
    {
        $initiativeDto = self::denormalizeDto($initiative);

        $violations = $this->validator->validate($initiativeDto, groups: $group);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        return $initiative;
    }
}
