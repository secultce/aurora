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
use DateTime;
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

    public function testFindUserInscriptions(): void
    {
        $result = $this->service->findUserInscriptionsWithDetails();

        $expectedResult = [
            [
                'opportunity' => 'Chamada para Oficinas de Artesanato - Feira de Cultura Popular',
                'phase' => 'Fase de documentos',
                'phaseDescription' => 'Fase de documentos para as oficinas de Artesanato na Feira de Cultura Popular',
                'startDate' => new DateTime('2024-08-15 00:00:00.0'),
                'endDate' => new DateTime('2024-08-20 00:00:00.0'),
            ],
            [
                'opportunity' => 'Credenciamento de Quadrilhas Juninas - São João do Nordeste',
                'phase' => 'Fase de submissão',
                'phaseDescription' => 'Fase de submissão para o credenciamento de Quadrilhas Juninas - São João do Nordeste',
                'startDate' => new DateTime('2024-07-15 00:00:00.0'),
                'endDate' => new DateTime('2024-07-18 00:00:00.0'),
            ],
            [
                'opportunity' => 'Inscrição para o Festival de Danças Folclóricas - Encontro Nordestino',
                'phase' => 'Fase de documentação',
                'phaseDescription' => 'Fase de documentação de inscrição para o Festival de Danças Folclóricas - Encontro Nordestino',
                'startDate' => new DateTime('2024-08-22 00:00:00.0'),
                'endDate' => new DateTime('2024-08-24 00:00:00.0 '),
            ],
            [
                'opportunity' => 'Edital de Patrocínio para Grupos de Maracatu - Carnaval Cultural',
                'phase' => 'Fase de submissão',
                'phaseDescription' => null,
                'startDate' => new DateTime('2024-08-28 00:00:00.0'),
                'endDate' => new DateTime('2024-09-01 00:00:00.0'),
            ],
        ];

        foreach ($expectedResult as $index => $expectedItem) {
            $actualItem = $result[$index];

            self::assertEquals($expectedItem['opportunity'], $actualItem['opportunity'], 'O nome da oportunidade não corresponde.');
            self::assertEquals($expectedItem['phase'], $actualItem['phase'], 'O nome da fase não corresponde.');
            self::assertEquals($expectedItem['phaseDescription'], $actualItem['phaseDescription'], 'A descrição da fase não corresponde.');
            self::assertEquals($expectedItem['startDate'], $actualItem['startDate'], 'A data de início não corresponde.');
            self::assertEquals($expectedItem['endDate'], $actualItem['endDate'], 'A data de término não corresponde.');
        }
    }
}
