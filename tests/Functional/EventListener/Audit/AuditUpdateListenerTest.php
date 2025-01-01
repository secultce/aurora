<?php

declare(strict_types=1);

namespace App\Tests\Functional\EventListener\Audit;

use App\DataFixtures\Entity\SpaceFixtures;
use App\DataFixtures\Entity\UserFixtures;
use App\Document\SpaceTimeline;
use App\Tests\AbstractWebTestCase;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditUpdateListenerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/spaces';

    private ?DocumentManager $documentManager = null;

    protected function setUp(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $this->documentManager = $container->get(DocumentManager::class);
    }

    public function testAuditUpdate(): void
    {
        $requestBody = ['name' => 'Hello world!'];

        /* @var SpaceTimeline[] $spaceTimelinesPreUpdate */
        $spaceTimelinesPreUpdate = $this->documentManager->getRepository(SpaceTimeline::class)
            ->findBy(['resourceId' => SpaceFixtures::SPACE_ID_4, 'userId' => UserFixtures::USER_ID_2]);

        $url = sprintf('%s/%s', self::BASE_URL, SpaceFixtures::SPACE_ID_4);

        $client = static::apiClient();

        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        if (null !== static::$kernel) {
            static::ensureKernelShutdown();
        }

        /** @var SpaceTimeline[] $spaceTimelinesPostUpdate */
        $spaceTimelinesPostUpdate = $this->documentManager->getRepository(SpaceTimeline::class)
            ->findBy(['resourceId' => SpaceFixtures::SPACE_ID_4, 'userId' => UserFixtures::USER_ID_2]);

        self::assertEquals('The resource was updated', $spaceTimelinesPostUpdate[0]->getTitle());
        self::assertSame(count($spaceTimelinesPostUpdate), count($spaceTimelinesPreUpdate) + 1);

        $spaceTimelineUpdateArray = array_udiff($spaceTimelinesPostUpdate, $spaceTimelinesPreUpdate, function ($a, $b) {
            return $a->getId() <=> $b->getId();
        });

        $spaceTimelineUpdate = reset($spaceTimelineUpdateArray);

        $this->documentManager->remove($spaceTimelineUpdate);
        $this->documentManager->flush();
    }
}
