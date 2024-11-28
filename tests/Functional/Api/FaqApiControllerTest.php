<?php

declare(strict_types=1);

namespace App\tests\Functional\Api;

use App\DataFixtures\Entity\FaqFixtures;
use App\Entity\Faq;
use App\Tests\AbstractWebTestCase;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class FaqApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/faqs';

    public function testCanCreateAFaqRequestBody(): void
    {
        $client = static::apiClient();

        $requestBody = [
            'id' => Uuid::v4()->toRfc4122(),
            'question' => 'Question test?',
            'answer' => 'Answer test.',
        ];

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $faq = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Faq::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'question' => 'Question test?',
            'answer' => 'Answer test.',
            'active' => true,
            'createdAt' => $faq->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationCreateCases')]
    public function testValidationCreate(array $requestBody, array $expectedErrors): void
    {
        $client = static::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationCreateCases(): array
    {
        $requestBody = [
            'id' => Uuid::v4()->toRfc4122(),
            'question' => 'Question test?',
            'answer' => 'Answer test.',
        ];

        return [
            'missing required fields' => [
                'requestBody' => [],
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value should not be blank.'],
                    ['field' => 'question', 'message' => 'This value should not be blank.'],
                    ['field' => 'answer', 'message' => 'This value should not be blank.'],
                ],
            ],
            'id is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['id' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'question should be a string' => [
                'requestBody' => array_merge($requestBody, ['question' => 123]),
                'expectedErrors' => [
                    ['field' => 'question', 'message' => 'This value should be of type string.'],
                ],
            ],
            'answer should be a string' => [
                'requestBody' => array_merge($requestBody, ['answer' => 123]),
                'expectedErrors' => [
                    ['field' => 'answer', 'message' => 'This value should be of type string.'],
                ],
            ],
            'answer is too short' => [
                'requestBody' => array_merge($requestBody, ['answer' => 'a']),
                'expectedErrors' => [
                    ['field' => 'answer', 'message' => 'This value is too short. It should have 2 characters or more.'],
                ],
            ],
            'answer is too long' => [
                'requestBody' => array_merge($requestBody, ['answer' => str_repeat('a', 258)]),
                'expectedErrors' => [
                    ['field' => 'answer', 'message' => 'This value is too long. It should have 255 characters or less.'],
                ],
            ],
        ];
    }

    public function testCanUpdate(): void
    {
        $requestBody = [
            'question' => 'Question test 2?',
            'answer' => 'Answer test 2.',
        ];

        $url = sprintf('%s/%s', self::BASE_URL, FaqFixtures::FAQ_ID_1);

        $client = self::apiClient();

        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $faq = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Faq::class, FaqFixtures::FAQ_ID_1);

        $this->assertResponseBodySame([
            'id' => FaqFixtures::FAQ_ID_1,
            'question' => 'Question test 2?',
            'answer' => 'Answer test 2.',
            'active' => true,
            'createdAt' => $faq->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $faq->getUpdatedAt()->format(DateTimeInterface::ATOM),
        ]);
    }

    #[DataProvider('provideValidationUpdateCases')]
    public function testValidationUpdate(array $requestBody, array $expectedErrors): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, FaqFixtures::FAQ_ID_3);
        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationUpdateCases(): array
    {
        $requestBody = [
            'question' => 'Question test 3?',
            'answer' => 'Answer test 3.',
        ];

        return [
            'active should be a boolean' => [
                'requestBody' => array_merge($requestBody, ['active' => 123]),
                'expectedErrors' => [
                    ['field' => 'active', 'message' => 'This value should be of type boolean.'],
                ],
            ],
            'question should be a string' => [
                'requestBody' => array_merge($requestBody, ['question' => 123]),
                'expectedErrors' => [
                    ['field' => 'question', 'message' => 'This value should be of type string.'],
                ],
            ],
            'answer should be a string' => [
                'requestBody' => array_merge($requestBody, ['answer' => 123]),
                'expectedErrors' => [
                    ['field' => 'answer', 'message' => 'This value should be of type string.'],
                ],
            ],
        ];
    }
}
