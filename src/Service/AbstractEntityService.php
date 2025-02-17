<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\EntityManagerAndEntityClassNotSetException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

abstract readonly class AbstractEntityService
{
    protected const array DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private Security $security,
        private ?EntityManagerInterface $entityManager = null,
        private ?string $entityClass = null,
    ) {
    }

    public function getDefaultParams(): array
    {
        return self::DEFAULT_FILTERS;
    }

    public function getUserParams(): array
    {
        $params = self::DEFAULT_FILTERS;

        if (null !== $this->security->getUser()) {
            $agents = $this->security->getUser()->getAgents()->getValues();

            $params['createdBy'] = $agents;
        }

        return $params;
    }

    public function getAgentsFromLoggedUser(): array
    {
        return $this->security->getUser()->getAgents()->getValues();
    }

    public function countRecentRecords(int $days): int
    {
        if (null === $this->entityManager and null === $this->entityClass) {
            throw new EntityManagerAndEntityClassNotSetException();
        }

        $metadata = $this->entityManager->getClassMetadata($this->entityClass);
        $tableName = $metadata->getTableName();

        $sql = sprintf(
            "SELECT COUNT(*) as count FROM %s WHERE created_at >= NOW() - INTERVAL '%d DAY'",
            $tableName,
            $days
        );

        $statement = $this->entityManager->getConnection()->prepare($sql);

        return (int) $statement->executeQuery()->fetchAssociative()['count'];
    }
}
