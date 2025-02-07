<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tag;
use App\Repository\Interface\TagRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function save(Tag $tag): Tag
    {
        $this->getEntityManager()->persist($tag);
        $this->getEntityManager()->flush();

        return $tag;
    }

    public function remove(Tag $tag): void
    {
        $this->getEntityManager()->remove($tag);
        $this->getEntityManager()->flush();
    }
}
