<?php

declare(strict_types=1);

namespace DoctrineMigrationsOdm;

use App\Document\PhaseTimeline;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Uid\Uuid;

final class Version20241105121146
{
    public function up(DocumentManager $dm): void
    {
        $documentTimeline = new PhaseTimeline();
        $documentTimeline->setUserId(Uuid::v4()->toRfc4122());
        $documentTimeline->setResourceId(Uuid::v4()->toRfc4122());
        $documentTimeline->setPriority(1);
        $documentTimeline->setDatetime(new DateTime());
        $documentTimeline->setDevice('linux');
        $documentTimeline->setPlatform('api');
        $documentTimeline->setFrom([]);
        $documentTimeline->setTo([]);

        $dm->persist($documentTimeline);
        $dm->flush();
    }

    public function down(DocumentManager $dm): void
    {
        $dm->getDocumentCollection(PhaseTimeline::class)->drop();
    }
}
