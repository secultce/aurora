<?php

declare(strict_types=1);

namespace App\Tests\Functional\Repositories;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class TagRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private TagRepository $tagRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->tagRepository = $this->entityManager->getRepository(Tag::class);
    }

    public function testRemoveTag(): void
    {
        $tag = new Tag();
        $tag->setId(Uuid::v4());
        $tag->setName('Test Tag');
        $this->tagRepository->save($tag);

        $this->entityManager->clear();
        $foundTag = $this->tagRepository->find($tag->getId());
        $this->assertNotNull($foundTag);

        $this->tagRepository->remove($foundTag);

        $this->entityManager->clear();
        $deletedTag = $this->tagRepository->find($tag->getId());
        $this->assertNull($deletedTag);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        unset($this->entityManager);
    }
}
