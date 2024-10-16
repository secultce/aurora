<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;
}
