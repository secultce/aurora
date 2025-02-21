<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\DataFixtures\Entity\ArchitecturalAccessibilityFixtures;
use App\Entity\ArchitecturalAccessibility;
use App\Service\Interface\ArchitecturalAccessibilityServiceInterface;
use App\Tests\Fixtures\ArchitecturalAccessibilityTestFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class ArchitecturalAccessibilityServiceTest extends KernelTestCase
{
    private ArchitecturalAccessibilityServiceInterface $service;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->service = self::getContainer()->get(ArchitecturalAccessibilityServiceInterface::class);
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCreateArchitecturalAccessibility(): void
    {
        $data = ArchitecturalAccessibilityTestFixtures::dataCreate();

        $this->service->create($data);

        $architecturalAccessibility = $this->entityManager->find(ArchitecturalAccessibility::class, Uuid::fromString($data['id']));

        self::assertNotNull($architecturalAccessibility);
        self::assertEquals($data['name'], $architecturalAccessibility->getName());
    }

    public function testUpdateArchitecturalAccessibility(): void
    {
        $id = Uuid::fromString(ArchitecturalAccessibilityFixtures::ARCHITECTURAL_ACCESSIBILITY_ID_2);
        $data = ArchitecturalAccessibilityTestFixtures::dataUpdate();

        $this->service->update($id, $data);

        $architecturalAccessibility = $this->entityManager->find(ArchitecturalAccessibility::class, $id);

        self::assertEquals($data['name'], $architecturalAccessibility->getName());
        self::assertEquals($data['description'], $architecturalAccessibility->getDescription());
    }

    public function testGetArchitecturalAccessibility(): void
    {
        $id = Uuid::fromString(ArchitecturalAccessibilityFixtures::ARCHITECTURAL_ACCESSIBILITY_ID_1);

        $architecturalAccessibility = $this->service->getOne($id);

        self::assertEquals($id, $architecturalAccessibility->getId());
    }

    public function testListArchitecturalAccessibilities(): void
    {
        $limit = 3;

        $list = $this->service->list($limit);

        self::assertCount($limit, $list);
    }

    public function testRemoveArchitecturalAccessibility(): void
    {
        $id = Uuid::fromString(ArchitecturalAccessibilityFixtures::ARCHITECTURAL_ACCESSIBILITY_ID_3);

        $this->service->remove($id);

        $architecturalAccessibility = $this->entityManager->find(ArchitecturalAccessibility::class, $id);

        self::assertNull($architecturalAccessibility);
    }
}
