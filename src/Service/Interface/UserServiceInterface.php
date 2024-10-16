<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

interface UserServiceInterface
{
    public function get(Uuid $id): User;

    public function update(Uuid $id, array $user): User;
}
