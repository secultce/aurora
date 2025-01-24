<?php

declare(strict_types=1);

namespace App\Tests\Unit\Document;

use App\DataFixtures\Entity\UserFixtures;
use App\Document\InscriptionPhaseReviewTimeline;
use DateTime;
use PHPUnit\Framework\TestCase;

class InscriptionPhaseReviewDocumentTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $timeline = new InscriptionPhaseReviewTimeline();

        $id = '66eb140519186a653156db20';
        $userId = UserFixtures::USER_ID_1;
        $resourceId = UserFixtures::USER_ID_1;
        $title = 'Review Title';
        $priority = 2;
        $datetime = new DateTime('2024-08-10T14:30:00+00:00');
        $device = 'windows';
        $platform = 'web';
        $from = ['status' => 'pending'];
        $to = ['status' => 'approved'];

        $timeline->setId($id);
        $timeline->setUserId($userId);
        $timeline->setResourceId($resourceId);
        $timeline->setTitle($title);
        $timeline->setPriority($priority);
        $timeline->setDatetime($datetime);
        $timeline->setDevice($device);
        $timeline->setPlatform($platform);
        $timeline->setFrom($from);
        $timeline->setTo($to);

        $this->assertEquals($id, $timeline->getId());
        $this->assertEquals($userId, $timeline->getUserId());
        $this->assertEquals($resourceId, $timeline->getResourceId());
        $this->assertEquals($title, $timeline->getTitle());
        $this->assertEquals($priority, $timeline->getPriority());
        $this->assertEquals($datetime, $timeline->getDatetime());
        $this->assertEquals($device, $timeline->getDevice());
        $this->assertEquals($platform, $timeline->getPlatform());
        $this->assertEquals($from, $timeline->getFrom());
        $this->assertEquals($to, $timeline->getTo());
    }
}
