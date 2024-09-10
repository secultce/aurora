<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Event;
use Symfony\Component\Uid\Uuid;

interface EventServiceInterface
{
    public function get(Uuid $id): Event;

    public function list(): array;
}
