<?php

declare(strict_types=1);

namespace App\Tests\Functional\Repositories;

use App\Entity\ArchitecturalAccessibility;
use App\Repository\ArchitecturalAccessibilityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class ArchitecturalAccessibilityRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ArchitecturalAccessibilityRepository $architecturalAccessibilityRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->architecturalAccessibilityRepository = $this->entityManager->getRepository(ArchitecturalAccessibility::class);
    }

    public function testSaveArchitecturalAccessibility(): void
    {
        $architecturalAccessibility = new ArchitecturalAccessibility();
        $architecturalAccessibility->setId(Uuid::v4());
        $architecturalAccessibility->setName('Test Accessibility');
        $architecturalAccessibility->setDescription('Test description');

        $this->architecturalAccessibilityRepository->save($architecturalAccessibility);

        $this->entityManager->clear();
        $foundAccessibility = $this->architecturalAccessibilityRepository->find($architecturalAccessibility->getId());
        $this->assertNotNull($foundAccessibility);
        $this->assertEquals('Test Accessibility', $foundAccessibility->getName());
    }

    public function testRemoveArchitecturalAccessibility(): void
    {
        $architecturalAccessibility = new ArchitecturalAccessibility();
        $architecturalAccessibility->setId(Uuid::v4());
        $architecturalAccessibility->setName('Test Accessibility');
        $architecturalAccessibility->setDescription('Test description');

        $this->architecturalAccessibilityRepository->save($architecturalAccessibility);

        $this->entityManager->clear();
        $foundAccessibility = $this->architecturalAccessibilityRepository->find($architecturalAccessibility->getId());
        $this->assertNotNull($foundAccessibility);

        $this->architecturalAccessibilityRepository->remove($foundAccessibility);

        $this->entityManager->clear();
        $deletedAccessibility = $this->architecturalAccessibilityRepository->find($architecturalAccessibility->getId());
        $this->assertNull($deletedAccessibility);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        unset($this->entityManager);
    }
}
