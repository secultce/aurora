<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\Entity\Space;
use App\Entity\User;
use App\Exception\EntityManagerAndEntityClassNotSetException;
use App\Service\AbstractEntityService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;

class AbstractEntityServiceTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private Security $security;
    private AbstractEntityService $entityService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->security = $this->createMock(Security::class);
        $user = $this->createMock(User::class);

        $user->method('getAgents')->willReturn(new ArrayCollection());
        $this->security->method('getUser')->willReturn($user);

        $this->entityService = new readonly class ($this->security, $this->entityManager, Space::class) extends AbstractEntityService {
        };
    }

    public function testGetDefaultParams(): void
    {
        $defaultParams = $this->entityService->getDefaultParams();
        $this->assertEquals(['deletedAt' => null], $defaultParams);
    }

    public function testGetUserParams(): void
    {
        $userParams = $this->entityService->getUserParams();
        $this->assertArrayHasKey('createdBy', $userParams);
        $this->assertIsArray($userParams['createdBy']);
    }

    public function testGetAgentsFromLoggedUser(): void
    {
        $agents = $this->entityService->getAgentsFromLoggedUser();
        $this->assertIsArray($agents);
    }

    public function testCountRecentRecords(): void
    {
        $days = 2;

        $result = $this->createMock(Result::class);
        $result->method('fetchAssociative')->willReturn(['count' => 5]);

        $statement = $this->createMock(Statement::class);
        $statement->method('executeQuery')->willReturn($result);

        $connection = $this->createMock(Connection::class);
        $connection->method('prepare')->willReturn($statement);

        $this->entityManager->method('getConnection')->willReturn($connection);

        $metadata = $this->createMock(ClassMetadata::class);
        $metadata->method('getTableName')->willReturn('spaces');
        $this->entityManager->method('getClassMetadata')->willReturn($metadata);

        $recentRecords = $this->entityService->countRecentRecords($days);

        $this->assertEquals(5, $recentRecords);
    }

    public function testCountRecentRecordsThrowsException(): void
    {
        $this->expectException(EntityManagerAndEntityClassNotSetException::class);

        $this->expectExceptionMessage('For use this method can be pass EntityManager and Entity ClassName in the constructor from this service.');

        $entityServiceWithoutEntityManager = new readonly class ($this->security, null, null) extends AbstractEntityService {
        };

        $entityServiceWithoutEntityManager->countRecentRecords(7);
    }
}
