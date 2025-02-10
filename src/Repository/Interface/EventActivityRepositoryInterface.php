<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\EventActivity;

interface EventActivityRepositoryInterface
{
    public function save(EventActivity $eventActivity): EventActivity;
}
