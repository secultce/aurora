<?php

declare(strict_types=1);

namespace DoctrineMigrationsOdm;

use App\Document\UserTimeline;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Uid\Uuid;

final class Version20240916182953
{
    public function up(DocumentManager $dm): void
    {
        $documentTimeline = new UserTimeline();
        $documentTimeline->setUserId(Uuid::v4()->toString());
        $documentTimeline->setResourceId(Uuid::v4()->toString());
        $documentTimeline->setTitle('');
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
        $dm->getDocumentCollection(UserTimeline::class)->drop();
    }
}
