<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\EventActivity;
use App\Exception\EventActivity\EventActivityResourceNotFoundException;
use App\Repository\Interface\EventActivityRepositoryInterface;
use App\Service\Interface\EventActivityServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;

readonly class EventActivityService extends AbstractEntityService implements EventActivityServiceInterface
{
    public function __construct(
        private EventActivityRepositoryInterface $repository,
        private Security $security,
    ) {
        parent::__construct($this->security);
    }

    public function findBy(array $params = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getUserParams()],
            ['startDate' => 'DESC'],
            $limit
        );
    }

    public function findOneBy(array $params): ?EventActivity
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
    }

    public function get(Uuid $event, Uuid $id): EventActivity
    {
        $event = $this->repository->findOneBy([
            'id' => $id,
            'event' => $event,
        ]);

        if (null === $event) {
            throw new EventActivityResourceNotFoundException();
        }

        return $event;
    }

    public function list(Uuid $event, int $limit = 50, array $params = []): array
    {
        $params['event'] = $event;

        return $this->repository->findBy(
            [...$params],
            ['startDate' => 'DESC'],
            $limit
        );
    }

    public function remove(Uuid $event, Uuid $id): void
    {
        $eventActivity = $this->repository->findOneBy(['id' => $id, 'event' => $event]);

        if (null === $eventActivity) {
            throw new EventActivityResourceNotFoundException();
        }

        $this->repository->remove($eventActivity);
    }
}
