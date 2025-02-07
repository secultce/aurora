<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\Tag;

interface TagRepositoryInterface
{
    public function save(Tag $tag): Tag;

    public function remove(Tag $tag): void;
}
