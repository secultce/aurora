<?php

declare(strict_types=1);

namespace App\Tests\Unit\Document;

use App\Document\UserTimeline;
use App\Tests\AbstractWebTestCase;
use DateTime;

class UserDocumentTest extends AbstractWebTestCase
{
    public function testGettersAndSettersFromUserDocumentShouldBeSuccessful()
    {
        $date = new DateTime();

        $user = new UserTimeline();
        $user->setId('b4169426-9c01-4c92-ba36-4a276aedc469');
        $user->setUserId('db91c782-3476-4446-8ded-5d0f9cf110ba');
        $user->setResourceId('84a4a7d0-9a70-4554-bd62-c54fa570c6ea');
        $user->setTitle('the entity was updated');
        $user->setPriority(1);
        $user->setDatetime($date);
        $user->setDevice('smartphone');
        $user->setPlatform('android');
        $user->setFrom([
            'name' => 'Agent X'
        ]);
        $user->setTo([
            'name' => 'Agent Y'
        ]);

        $this->assertTrue($user->getId() === 'b4169426-9c01-4c92-ba36-4a276aedc469');
        $this->assertTrue($user->getUserId() === 'db91c782-3476-4446-8ded-5d0f9cf110ba');
        $this->assertTrue($user->getResourceId() === '84a4a7d0-9a70-4554-bd62-c54fa570c6ea');
        $this->assertTrue($user->getTitle() === 'the entity was updated');
        $this->assertTrue($user->getPriority() === 1);
        $this->assertTrue($user->getDatetime() === $date);
        $this->assertTrue($user->getDevice() === 'smartphone');
        $this->assertTrue($user->getPlatform() === 'android');
        $this->assertTrue($user->getFrom() === [
            'name' => 'Agent X'
        ]);
        $this->assertTrue($user->getTo() === [
            'name' => 'Agent Y'
        ]);
    }
}
