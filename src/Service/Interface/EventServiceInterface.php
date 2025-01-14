<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Agent;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

interface EventServiceInterface
{
    public function count(?Agent $createdBy = null): int;

    public function create(array $event): Event;

    public function findBy(array $params = []): array;

    public function findOneBy(array $params): ?Event;

    public function get(Uuid $id): Event;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;

    public function update(Uuid $identifier, array $event): Event;

    public function updateImage(Uuid $id, UploadedFile $uploadedFile): Event;
}
