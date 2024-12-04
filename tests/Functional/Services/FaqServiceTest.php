<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\DataFixtures\Entity\FaqFixtures;
use App\Entity\Faq;
use App\Service\Interface\FaqServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class FaqServiceTest extends KernelTestCase
{
    private FaqServiceInterface $faqService;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->faqService = self::getContainer()->get(FaqServiceInterface::class);
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCreateFaq(): void
    {
        $data = [
            'id' => Uuid::v4()->toRfc4122(),
            'question' => 'Question test?',
            'answer' => 'Answer test.',
        ];

        $this->faqService->create($data);

        $faq = $this->entityManager->find(Faq::class, Uuid::v4()->fromRfc4122($data['id']));

        self::assertNotNull($faq);
    }

    public function testUpdateFaq(): void
    {
        $faqId = Uuid::fromRfc4122(FaqFixtures::FAQ_ID_1);

        $data = [
            'question' => 'test question',
        ];

        $this->faqService->update($faqId, $data);

        $faq = $this->entityManager->find(Faq::class, $faqId);

        self::assertEquals($data['question'], $faq->getQuestion());
    }

    public function testListLimit(): void
    {
        $limit = 3;

        $list = $this->faqService->list($limit);

        self::assertCount($limit, $list);
    }

    public function testListIsOrderedDescending(): void
    {
        $list = $this->faqService->list();

        self::assertGreaterThanOrEqual($list[1]->getCreatedAt(), $list[0]->getCreatedAt());
        self::assertGreaterThanOrEqual($list[2]->getCreatedAt(), $list[1]->getCreatedAt());
        self::assertGreaterThanOrEqual($list[3]->getCreatedAt(), $list[2]->getCreatedAt());
    }

    public function testDisableFaq(): void
    {
        $faqId = Uuid::fromRfc4122(FaqFixtures::FAQ_ID_1);

        $this->faqService->remove($faqId);

        $faq = $this->entityManager->find(Faq::class, $faqId);

        self::assertFalse($faq->isActive());
    }
}
