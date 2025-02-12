<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Tag;
use Symfony\Component\Uid\Uuid;

interface TagServiceInterface
{
    public function create(array $tag): Tag;

    public function get(Uuid $id): Tag;

    public function list(int $limit = 50): array;

    public function update(Uuid $id, array $tag): Tag;

    public function remove(Uuid $id): void;
}
