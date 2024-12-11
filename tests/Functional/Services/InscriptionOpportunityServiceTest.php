<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\Entity\InscriptionOpportunity;
use App\Entity\InscriptionPhase;
use App\Entity\Phase;
use App\Repository\UserRepository;
use App\Service\Interface\InscriptionOpportunityServiceInterface;
use App\Tests\AbstractWebTestCase;
use App\Tests\Fixtures\InscriptionOpportunityTestFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class InscriptionOpportunityServiceTest extends AbstractWebTestCase
{
    private InscriptionOpportunityServiceInterface $service;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $userRepository = $container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('alessandrofeitoza@example.com');
        $client->loginUser($testUser);

        $this->service = $container->get(InscriptionOpportunityServiceInterface::class);
        $this->entityManager = $container->get(EntityManagerInterface::class);
    }

    public function testCreateInscriptionInOpportunityAndPhase(): void
    {
        $requestBody = InscriptionOpportunityTestFixtures::complete();

        $this->service->create(Uuid::v4()->fromRfc4122($requestBody['opportunity']), $requestBody);

        $inscriptionOpportunity = $this->entityManager->find(InscriptionOpportunity::class, $requestBody['id']);

        $firstPhase = $this->entityManager->getRepository(Phase::class)->findOneBy(
            ['opportunity' => $requestBody['opportunity']],
            ['sequence' => 'ASC']
        );

        self::assertNotNull($inscriptionOpportunity);
        self::assertNotNull($firstPhase);

        $inscriptionPhase = $this->entityManager->getRepository(InscriptionPhase::class)->findBy([
            'agent' => $requestBody['agent'],
            'phase' => $firstPhase->getId(),
        ]);

        self::assertNotNull($inscriptionPhase);
    }
}
