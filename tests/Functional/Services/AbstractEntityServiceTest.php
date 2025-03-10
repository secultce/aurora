<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\DataFixtures\Entity\AgentFixtures;
use App\DTO\SpaceDto;
use App\Entity\Space;
use App\Entity\User;
use App\Exception\EntityManagerAndEntityClassNotSetException;
use App\Exception\ValidatorException;
use App\Service\AbstractEntityService;
use App\Service\Interface\FileServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractEntityServiceTest extends KernelTestCase
{
    private Security $security;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;
    private FileServiceInterface $fileService;
    private ParameterBagInterface $parameterBag;
    private $entityService;
    private string $imagePath;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->security = $this->createMock(Security::class);
        $this->serializer = self::getContainer()->get(SerializerInterface::class);
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
        $this->fileService = $this->createMock(FileServiceInterface::class);
        $this->parameterBag = $this->createMock(ParameterBagInterface::class);
        $this->imagePath = 'app.dir.space.profile';
        $user = $this->createMock(User::class);

        $user->method('getAgents')->willReturn(new ArrayCollection());
        $this->security->method('getUser')->willReturn($user);

        $this->entityService = new readonly class ($this->security, $this->serializer, $this->validator, $this->entityManager, Space::class, $this->fileService, $this->parameterBag, $this->imagePath) extends AbstractEntityService {
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

    public function testValidateInput(): void
    {
        $data = [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Space',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'maxCapacity' => 10,
            'isAccessible' => true,
        ];
        $dtoClass = SpaceDto::class;
        $group = 'create';

        $result = $this->entityService->validateInput($data, $dtoClass, $group);

        $this->assertEquals($data, $result);
    }

    public function testValidateInputThrowsException(): void
    {
        $this->expectException(ValidatorException::class);

        $data = ['name' => ''];
        $dtoClass = SpaceDto::class;
        $group = 'create';

        $this->entityService->validateInput($data, $dtoClass, $group);

        $this->expectExceptionMessage('Validation failed: field: This value should not be blank.');
    }

    public function testDenormalizeDto(): void
    {
        $data = ['name' => 'Space'];
        $dtoClass = SpaceDto::class;

        $this->serializer->denormalize($data, $dtoClass);

        $result = $this->entityService->denormalizeDto($data, $dtoClass);
        $this->assertInstanceOf($dtoClass, $result);
    }
}
