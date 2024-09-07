<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Space;
use App\Exception\Space\SpaceResourceNotFoundException;
use App\Repository\Interface\SpaceRepositoryInterface;
use App\Service\Interface\SpaceServiceInterface;
use DateTime;
use Symfony\Component\Uid\Uuid;

readonly class SpaceService implements SpaceServiceInterface
{
    private const DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private SpaceRepositoryInterface $repository
    ) {
    }

    public function get(Uuid $id): Space
    {
        $space = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $space) {
            throw new SpaceResourceNotFoundException();
        }

        return $space;
    }

    public function list(): array
    {
        return $this->repository->findBy(self::DEFAULT_FILTERS);
    }

    public function remove(Uuid $id): void
    {
        $space = $this->get($id);
        $space->setDeletedAt(new DateTime());

        $this->repository->save($space);
    }
}
