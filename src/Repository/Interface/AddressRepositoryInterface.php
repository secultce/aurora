<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\Address;

interface AddressRepositoryInterface
{
    public function save(Address $address): Address;
}
