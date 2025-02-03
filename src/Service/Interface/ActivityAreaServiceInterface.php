<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\ActivityArea;
use Symfony\Component\Uid\Uuid;

interface ActivityAreaServiceInterface
{
    public function get(Uuid $id): ActivityArea;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;
}
