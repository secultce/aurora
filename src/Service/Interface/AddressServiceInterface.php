<?php

namespace App\Service\Interface;

use App\Entity\Address;
use Symfony\Component\Uid\Uuid;

interface AddressServiceInterface
{
    public function create(array $address): Address;

    public function update(Uuid $id, array $address): Address;
}