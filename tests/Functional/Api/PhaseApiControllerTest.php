<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\OpportunityFixtures;
use App\Entity\Phase;
use App\Tests\AbstractWebTestCase;
use App\Tests\Fixtures\PhaseTestFixtures;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class PhaseApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/opportunities/{opportunity}/phases';

    private ?ParameterBagInterface $parameterBag = null;

    protected function setUp(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $this->parameterBag = $container->get(ParameterBagInterface::class);
    }

    public function testCanCreateWithPartialRequestBody(): void
    {
        $requestBody = PhaseTestFixtures::partial();

        $client = static::apiClient();

        $url = str_replace('{opportunity}', OpportunityFixtures::OPPORTUNITY_ID_1, self::BASE_URL);

        $client->request(Request::METHOD_POST, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        /** @var Phase $phase */
        $phase = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Phase::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'description' => null,
            'startDate' => null,
            'endDate' => null,
            'status' => true,
            'sequence' => 4,
            'createdBy' => ['id' => $requestBody['createdBy']],
            'opportunity' => ['id' => $requestBody['opportunity']],
            'extraFields' => null,
            'createdAt' => $phase->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testCanCreateWithCompleteRequestBody(): void
    {
        $requestBody = PhaseTestFixtures::complete();

        $client = static::apiClient();

        $url = str_replace('{opportunity}', OpportunityFixtures::OPPORTUNITY_ID_1, self::BASE_URL);

        $client->request(Request::METHOD_POST, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        /** @var Phase $phase */
        $phase = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Phase::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'description' => $requestBody['description'],
            'startDate' => $phase->getStartDate()->format(DateTimeInterface::ATOM),
            'endDate' => $phase->getEndDate()->format(DateTimeInterface::ATOM),
            'status' => $requestBody['status'],
            'sequence' => 4,
            'createdBy' => ['id' => $requestBody['createdBy']],
            'opportunity' => ['id' => $requestBody['opportunity']],
            'extraFields' => $requestBody['extraFields'],
            'createdAt' => $phase->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationCreateCases')]
    public function testValidationCreate(array $requestBody, array $expectedErrors): void
    {
        $client = static::apiClient();

        $url = str_replace('{opportunity}', OpportunityFixtures::OPPORTUNITY_ID_1, self::BASE_URL);

        $client->request(Request::METHOD_POST, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationCreateCases(): array
    {
        $requestBody = PhaseTestFixtures::partial();

        return [
            'missing required fields' => [
                'requestBody' => [],
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value should not be blank.'],
                    ['field' => 'name', 'message' => 'This value should not be blank.'],
                    ['field' => 'createdBy', 'message' => 'This value should not be blank.'],
                ],
            ],
            'id is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['id' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'name is not a string' => [
                'requestBody' => array_merge($requestBody, ['name' => 123]),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value should be of type string.'],
                ],
            ],
            'name is too short' => [
                'requestBody' => array_merge($requestBody, ['name' => 'a']),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value is too short. It should have 2 characters or more.'],
                ],
            ],
            'name is too long' => [
                'requestBody' => array_merge($requestBody, ['name' => str_repeat('a', 101)]),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value is too long. It should have 100 characters or less.'],
                ],
            ],
            'createdBy should exist' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'createdBy', 'message' => 'This id does not exist.'],
                ],
            ],
            'extraFields should be a valid JSON' => [
                'requestBody' => array_merge($requestBody, ['extraFields' => 'invalid-json']),
                'expectedErrors' => [
                    ['field' => 'extraFields', 'message' => 'This value should be of type json object.'],
                ],
            ],
        ];
    }
}
