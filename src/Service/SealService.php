<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Seal;
use App\Exception\Seal\SealResourceNotFoundException;
use App\Repository\Interface\SealRepositoryInterface;
use App\Service\Interface\SealServiceInterface;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;

readonly class SealService extends AbstractEntityService implements SealServiceInterface
{
    public function __construct(
        private SealRepositoryInterface $repository,
        private Security $security,
    ) {
        parent::__construct($this->security);
    }

    public function findBy(array $params = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getUserParams()],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function findOneBy(array $params): ?Seal
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
    }

    public function get(Uuid $id): Seal
    {
        $seal = $this->repository->findOneBy([
            ...['id' => $id],
            ...$this->getDefaultParams(),
        ]);

        if (null === $seal) {
            throw new SealResourceNotFoundException();
        }

        return $seal;
    }

    public function list(int $limit = 50): array
    {
        return $this->repository->findBy(
            $this->getUserParams(),
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $seal = $this->findOneBy(
            [...['id' => $id], ...$this->getUserParams()]
        );

        if (null === $seal) {
            throw new SealResourceNotFoundException();
        }

        $seal->setDeletedAt(new DateTime());

        $this->repository->save($seal);
    }
}
