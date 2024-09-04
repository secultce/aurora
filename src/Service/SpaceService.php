<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Space;
use App\Exception\Space\SpaceResourceNotFoundException;
use App\Repository\Interface\SpaceRepositoryInterface;
use App\Service\Interface\SpaceServiceInterface;
use Symfony\Component\Uid\Uuid;

readonly class SpaceService implements SpaceServiceInterface
{
    public function __construct(
        private SpaceRepositoryInterface $repository
    ) {
    }

    public function get(Uuid $id): Space
    {
        $space = $this->repository->find($id);

        if (null === $space) {
            throw new SpaceResourceNotFoundException();
        }

        return $space;
    }

    public function list(): array
    {
        return $this->repository->findAll();
    }
}
