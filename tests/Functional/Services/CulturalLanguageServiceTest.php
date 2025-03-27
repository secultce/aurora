<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\DataFixtures\Entity\CulturalLanguageFixtures;
use App\Entity\CulturalLanguage;
use App\Exception\CulturalLanguage\CulturalLanguageResourceNotFoundException;
use App\Service\Interface\CulturalLanguageServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class CulturalLanguageServiceTest extends KernelTestCase
{
    private CulturalLanguageServiceInterface $service;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->service = self::getContainer()->get(CulturalLanguageServiceInterface::class);
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testGetCulturalLanguage(): void
    {
        $id = Uuid::fromString(CulturalLanguageFixtures::CULTURAL_LANGUAGE_ID_1);

        $culturalLanguage = $this->service->get($id);

        self::assertEquals($id, $culturalLanguage->getId());
    }

    public function testGetCulturalLanguageNotFound(): void
    {
        $this->expectException(CulturalLanguageResourceNotFoundException::class);

        $nonExistentId = Uuid::v4();
        $this->service->get($nonExistentId);
    }

    public function testListCulturalLanguages(): void
    {
        $limit = 3;

        $list = $this->service->list($limit);

        self::assertCount($limit, $list);
    }

    public function testRemoveCulturalLanguage(): void
    {
        $id = Uuid::fromString(CulturalLanguageFixtures::CULTURAL_LANGUAGE_ID_3);

        $this->service->remove($id);

        $culturalLanguage = $this->entityManager->find(CulturalLanguage::class, $id);

        self::assertNull($culturalLanguage);
    }

    public function testRemoveCulturalLanguageNotFound(): void
    {
        $this->expectException(CulturalLanguageResourceNotFoundException::class);

        $nonExistentId = Uuid::v4();
        $this->service->remove($nonExistentId);
    }
}
