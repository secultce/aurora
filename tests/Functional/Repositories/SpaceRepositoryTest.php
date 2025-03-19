<?php

declare(strict_types=1);

namespace App\Tests\Functional\Repositories;

use App\Entity\Agent;
use App\Entity\EntityAssociation;
use App\Entity\Space;
use App\Entity\User;
use App\Enum\EntityEnum;
use App\Repository\SpaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class SpaceRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private SpaceRepository $spaceRepository;
    private UserInterface $mockUser;

    protected function setUp(): void
    {
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->spaceRepository = $this->entityManager->getRepository(Space::class);

        $this->mockUser = new User();
        $userId = Uuid::v4();
        $this->mockUser->setId($userId);

        $tokenStorage = static::getContainer()->get('security.token_storage');
        assert($tokenStorage instanceof TokenStorageInterface);

        $token = new UsernamePasswordToken($this->mockUser, 'main');
        $tokenStorage->setToken($token);
    }

    public function testSaveSpace(): void
    {
        $agent = $this->createAgent();

        $space = new Space();
        $space->setId(Uuid::v4());
        $space->setName('Test Space');
        $space->setMaxCapacity(1);
        $space->setIsAccessible(true);
        $space->setCreatedBy($agent);

        $this->spaceRepository->save($space);

        $this->entityManager->clear();
        $foundSpace = $this->spaceRepository->find($space->getId());

        $this->assertNotNull($foundSpace);
        $this->assertEquals('Test Space', $foundSpace->getName());
    }

    public function testFindByNameAndEntityAssociation(): void
    {
        $agent = $this->createAgent();

        $space = new Space();
        $space->setId(Uuid::v4());
        $space->setName('Find Test Space');
        $space->setMaxCapacity(1);
        $space->setIsAccessible(true);
        $space->setCreatedBy($agent);
        $entityAssociation = new EntityAssociation();
        $entityAssociation->setId(Uuid::v4());
        $entityAssociation->setSpace($space);
        $entityAssociation->setWithSpace(true);
        $space->setEntityAssociation($entityAssociation);

        $this->spaceRepository->save($space);
        $this->entityManager->clear();

        $foundSpaces = $this->spaceRepository->findByNameAndEntityAssociation('Find Test', EntityEnum::SPACE, 10);
        $this->assertNotNull($foundSpaces[0]);
        $this->assertEquals('Find Test Space', $foundSpaces[0]->getName());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        unset($this->entityManager);
    }

    private function createAgent(): Agent
    {
        $agent = new Agent();
        $agent->setId(Uuid::v4());
        $agent->setName('Agente de Teste');
        $agent->setShortBio('Biografia curta para o agente de teste.');
        $agent->setLongBio('Biografia longa e detalhada para o agente de teste.');
        $agent->setCulture(true);
        $agent->setMain(false);

        $this->entityManager->persist($agent);
        $this->entityManager->flush();

        return $agent;
    }
}
