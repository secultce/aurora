<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Tag;
use App\Exception\Tag\TagResourceNotFoundException;
use App\Repository\Interface\TagRepositoryInterface;
use App\Service\Interface\TagServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;

readonly class TagService extends AbstractEntityService implements TagServiceInterface
{
    public function __construct(
        private TagRepositoryInterface $repository,
        private Security $security,
    ) {
        parent::__construct($this->security);
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
}
