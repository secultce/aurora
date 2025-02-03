<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ActivityArea;
use App\Exception\ActivityArea\ActivityAreaResourceNotFoundException;
use App\Repository\Interface\ActivityAreaRepositoryInterface;
use App\Service\Interface\ActivityAreaServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;

readonly class ActivityAreaService extends AbstractEntityService implements ActivityAreaServiceInterface
{
    public function __construct(
        private ActivityAreaRepositoryInterface $repository,
        private Security $security,
    ) {
        parent::__construct($this->security);
    }

    public function get(Uuid $id): ActivityArea
    {
        $activityArea = $this->findOneBy(['id' => $id]);

        if (null === $activityArea) {
            throw new ActivityAreaResourceNotFoundException();
        }

        return $activityArea;
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
        $activityArea = $this->findOneBy(['id' => $id]);

        if (null === $activityArea) {
            throw new ActivityAreaResourceNotFoundException();
        }

        $this->repository->remove($activityArea);
    }

    private function findOneBy(array $array): ?ActivityArea
    {
        return $this->repository->findOneBy($array);
    }
}
