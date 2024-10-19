<?php

declare(strict_types=1);

namespace DoctrineMigrationsOdm;

use App\Document\AuthTimeline;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Uid\Uuid;

final class Version20241021125440
{
    public function up(DocumentManager $dm): void
    {
        $documentTimeline = new AuthTimeline();
        $documentTimeline->setUserId(Uuid::v4()->toRfc4122());
        $documentTimeline->setPriority(1);
        $documentTimeline->setDatetime(new DateTime());
        $documentTimeline->setDevice('linux');
        $documentTimeline->setPlatform('api');
        $documentTimeline->setAction('login success');

        $dm->persist($documentTimeline);
        $dm->flush();
    }

    public function down(DocumentManager $dm): void
    {
        $dm->getDocumentCollection(AuthTimeline::class)->drop();
    }
}
