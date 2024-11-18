<?php

namespace App\Tests\Functional\Services;

use App\Service\AddressService;
use App\Service\Interface\AddressServiceInterface;
use App\Tests\Fixtures\AddressTestFixtures;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddressServiceTest extends KernelTestCase
{
    private AddressService $addressService;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->addressService = self::getContainer()->get(AddressService::class);
    }

    public function testCreateAddress()
    {
        $partialData = AddressTestFixtures::partial();

        try {
            $address = $this->addressService->create($partialData);
        } catch (\Throwable $exception) {
            $this->fail($exception->getConstraintViolationList());
        }

        $this->assertSame($partialData, $address->toArray());
    }

}