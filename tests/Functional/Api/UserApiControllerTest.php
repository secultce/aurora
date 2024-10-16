<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\UserFixtures;
use App\Entity\User;
use App\Tests\AbstractWebTestCase;
use App\Tests\Fixtures\ImageTestFixtures;
use App\Tests\Fixtures\UserTestFixtures;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/users';

    private ?ParameterBagInterface $parameterBag = null;

    protected function setUp(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $this->parameterBag = $container->get(ParameterBagInterface::class);
    }

    public function testCanUpdate(): void
    {
        $requestBody = UserTestFixtures::complete();
        unset($requestBody['id']);

        $url = sprintf('%s/%s', self::BASE_URL, UserFixtures::USER_ID_5);
        $client = self::apiClient();

        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $user = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(User::class, UserFixtures::USER_ID_5);

        $this->assertResponseBodySame([
            'id' => UserFixtures::USER_ID_5,
            'image' => $user->getImage(),
            'createdAt' => $user->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $user->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);
    }

    public function testCanUpdateImage(): void
    {
        $requestBody = UserTestFixtures::complete();
        unset($requestBody['id']);

        $client = self::apiClient();

        /* @var User $user */
        $userCreated = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(User::class, UserFixtures::USER_ID_5);

        $firstImage = str_replace($this->parameterBag->get('app.url.storage'), '', $userCreated->getImage());
        file_exists($firstImage);

        $url = sprintf('%s/%s', self::BASE_URL, UserFixtures::USER_ID_5);
        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $userUpdated = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(User::class, UserFixtures::USER_ID_5);

        $this->assertResponseBodySame([
            'id' => UserFixtures::USER_ID_5,
            'image' => $userUpdated->getImage(),
            'createdAt' => $userUpdated->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $userUpdated->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);

        self::assertFalse(file_exists($firstImage));

        $secondImage = str_replace($this->parameterBag->get('app.url.storage'), '', $userUpdated->getImage());
        file_exists($secondImage);
    }

    #[DataProvider('provideValidationUpdateCases')]
    public function testValidationUpdate(array $requestBody, array $expectedErrors): void
    {
        $client = self::apiClient();
        $url = sprintf('%s/%s', self::BASE_URL, UserFixtures::USER_ID_6);
        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationUpdateCases(): array
    {
        $requestBody = UserTestFixtures::partial();
        unset($requestBody['id']);

        return [
            'image not supported' => [
                'requestBody' => array_merge($requestBody, ['image' => ImageTestFixtures::getGif()]),
                'expectedErrors' => [
                    ['field' => 'image', 'message' => 'The mime type of the file is invalid ("image/gif"). Allowed mime types are "image/png", "image/jpg", "image/jpeg".'],
                ],
            ],
            'image size' => [
                'requestBody' => array_merge($requestBody, ['image' => ImageTestFixtures::getImageMoreThan2mb()]),
                'expectedErrors' => [
                    ['field' => 'image', 'message' => 'The file is too large (2.5 MB). Allowed maximum size is 2 MB.'],
                ],
            ],
        ];
    }
}
