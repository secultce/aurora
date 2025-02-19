<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\SpaceType;
use App\Exception\SpaceType\SpaceTypeResourceNotFoundException;
use App\Repository\Interface\SpaceTypeRepositoryInterface;
use App\Service\Interface\SpaceTypeServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;

readonly class SpaceTypeService extends AbstractEntityService implements SpaceTypeServiceInterface
{
    public function __construct(
        private SpaceTypeRepositoryInterface $repository,
        private Security $security
    ) {
        parent::__construct($this->security);
    }

    public function get(Uuid $id): SpaceType
    {
        $spaceType = $this->findOneBy(['id' => $id]);

        if (null === $spaceType) {
            throw new SpaceTypeResourceNotFoundException();
        }

        return $spaceType;
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
        $spaceType = $this->findOneBy(['id' => $id]);

        if (null === $spaceType) {
            throw new SpaceTypeResourceNotFoundException();
        }

        $this->repository->remove($spaceType);
    }

    private function findOneBy(array $array): ?SpaceType
    {
        return $this->repository->findOneBy($array);
    }
}
