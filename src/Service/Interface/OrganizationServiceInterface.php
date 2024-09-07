<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Organization;
use Symfony\Component\Uid\Uuid;

interface OrganizationServiceInterface
{
    public function get(Uuid $id): Organization;

    public function list(): array;

    public function remove(Uuid $id): void;
}
