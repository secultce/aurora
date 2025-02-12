<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\TagDto;
use App\Entity\Tag;
use App\Exception\Tag\TagResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\TagRepositoryInterface;
use App\Service\Interface\TagServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class TagService extends AbstractEntityService implements TagServiceInterface
{
    public function __construct(
        private TagRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security);
    }

    public function create(array $tag): Tag
    {
        $tag = self::validateInput($tag, TagDto::CREATE);

        $tagObj = $this->serializer->denormalize($tag, Tag::class);

        return $this->repository->save($tagObj);
    }

    public function get(Uuid $id): Tag
    {
        $tag = $this->findOneBy(['id' => $id]);

        if (null === $tag) {
            throw new TagResourceNotFoundException();
        }

        return $tag;
    }

    public function list(int $limit = 50, array $params = []): array
    {
        return $this->repository->findBy(
            $params,
            ['name' => 'ASC'],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $tag = $this->findOneBy(['id' => $id]);

        if (null === $tag) {
            throw new TagResourceNotFoundException();
        }

        $this->repository->remove($tag);
    }

    private function findOneBy(array $array): ?Tag
    {
        return $this->repository->findOneBy($array);
    }

    public function update(Uuid $id, array $tag): Tag
    {
        $tagFromDB = $this->get($id);

        $tagDto = self::validateInput($tag, TagDto::UPDATE);

        $tagObj = $this->serializer->denormalize($tagDto, Tag::class, context: [
            'object_to_populate' => $tagFromDB,
        ]);

        return $this->repository->save($tagObj);
    }

    private function validateInput(array $tag, string $group): array
    {
        $tagDto = $this->serializer->denormalize($tag, TagDto::class);

        $violations = $this->validator->validate($tagDto, groups: $group);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        return $tag;
    }
}
