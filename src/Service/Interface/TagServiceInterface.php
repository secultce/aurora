<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Tag;
use Symfony\Component\Uid\Uuid;

interface TagServiceInterface
{
    public function get(Uuid $id): Tag;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;
}
