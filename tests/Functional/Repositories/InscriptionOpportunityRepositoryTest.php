<?php

declare(strict_types=1);

namespace App\Tests\Functional\Repositories;

use App\DataFixtures\Entity\AgentFixtures;
use App\Entity\Agent;
use App\Entity\InscriptionOpportunity;
use App\Repository\InscriptionOpportunityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class InscriptionOpportunityRepositoryTest extends KernelTestCase
{
    private InscriptionOpportunityRepository $repository;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->repository = self::getContainer()->get(InscriptionOpportunityRepository::class);
        $this->entityManager = self::getContainer()->get('doctrine')->getManager();
    }

    public function testFindRecentByUser(): void
    {
        $agentId = Uuid::fromString(AgentFixtures::AGENT_ID_1);

        $userId = $this->entityManager
            ->find(Agent::class, $agentId)
            ->getUser()
            ->getId();

        $limit = 4;

        $result = $this->repository->findRecentByUser($userId, $limit);

        self::assertIsArray($result, 'O resultado deve ser um array');
        self::assertLessThanOrEqual($limit, count($result), "O resultado deve conter no máximo $limit itens");

        foreach ($result as $inscriptionOpportunity) {
            self::assertInstanceOf(
                InscriptionOpportunity::class,
                $inscriptionOpportunity,
                'Cada item deve ser uma instância de InscriptionOpportunity'
            );

            self::assertEquals(
                $agentId->toRfc4122(),
                $inscriptionOpportunity->getAgent()->getId()->toRfc4122(),
                'O agente associado deve corresponder ao ID das fixtures'
            );
        }
    }
}
