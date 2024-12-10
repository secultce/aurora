<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Address;
use App\Repository\Interface\AddressRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends AbstractRepository implements AddressRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function save(Address $address): Address
    {
        $this->getEntityManager()->persist($address);
        $this->getEntityManager()->flush();

        return $address;
    }
}
