<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Space;
use App\Enum\EntityEnum;
use App\Repository\Interface\SpaceRepositoryInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

class SpaceRepository extends AbstractRepository implements SpaceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Space::class);
    }

    public function save(Space $space): Space
    {
        $this->getEntityManager()->persist($space);
        $this->getEntityManager()->flush();

        return $space;
    }

    public function findByNameAndEntityAssociation(?string $name, EntityEnum $entityAssociation, int $limit): array
    {
        $sql = <<<EOT
                select s.*
                from space s
                left join entity_association ea ON s.id = ea.space_id
                where ea.with_$entityAssociation->name is true
                  and (cast(:name as varchar) is null or s.name ilike '%' || :name || '%')
                limit :limit
            EOT;

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(Space::class, 's');
        $rsm->addFieldResult('s', 'id', 'id');
        $rsm->addFieldResult('s', 'name', 'name');

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $query->setParameter('name', $name);
        $query->setParameter('limit', $limit);

        return $query->getResult();
    }
}
