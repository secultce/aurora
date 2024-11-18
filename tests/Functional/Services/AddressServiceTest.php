<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\Exception\ValidatorException;
use App\Service\Interface\AddressServiceInterface;
use App\Tests\Fixtures\AddressTestFixtures;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;

class AddressServiceTest extends KernelTestCase
{
    private AddressServiceInterface $addressService;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->addressService = self::getContainer()->get(AddressServiceInterface::class);
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCreateAddress(): void
    {
        $partialData = AddressTestFixtures::partial();

        $address = (object) [];
        try {
            $address = $this->addressService->create($partialData);
        } catch (ValidatorException $exception) {
            $this->fail((string) $exception->getConstraintViolationList());
        }

        $this->assertSame($partialData, $address->toArray());
    }
}
