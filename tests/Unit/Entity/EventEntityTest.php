<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Agent;
use App\Entity\Event;
use App\Entity\Initiative;
use App\Entity\Space;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class EventEntityTest extends TestCase
{
    public function testGetters(): void
    {
        $event = new Event();

        $id = Uuid::v4();
        $name = 'Festival de Música';
        $image = 'image.jpg';
        $agentGroup = new Agent();
        $space = new Space();
        $initiative = new Initiative();
        $parentEvent = new Event();
        $extraFields = ['key' => 'value'];
        $createdBy = new Agent();
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $deletedAt = new DateTime();

        $event->setId($id);
        $event->setName($name);
        $event->setImage($image);
        $event->setAgentGroup($agentGroup);
        $event->setSpace($space);
        $event->setInitiative($initiative);
        $event->setParent($parentEvent);
        $event->setExtraFields($extraFields);
        $event->setCreatedBy($createdBy);
        $event->setCreatedAt($createdAt);
        $event->setUpdatedAt($updatedAt);
        $event->setDeletedAt($deletedAt);

        $this->assertSame($id, $event->getId());
        $this->assertSame($name, $event->getName());
        $this->assertSame($image, $event->getImage());
        $this->assertSame($agentGroup, $event->getAgentGroup());
        $this->assertSame($space, $event->getSpace());
        $this->assertSame($initiative, $event->getInitiative());
        $this->assertSame($parentEvent, $event->getParent());
        $this->assertSame($extraFields, $event->getExtraFields());
        $this->assertSame($createdBy, $event->getCreatedBy());
        $this->assertSame($createdAt, $event->getCreatedAt());
        $this->assertSame($updatedAt, $event->getUpdatedAt());
        $this->assertSame($deletedAt, $event->getDeletedAt());
    }

    public function testToArray(): void
    {
        $event = new Event();
        $id = Uuid::v4();
        $event->setId($id);
        $event->setName('Festival');

        $agent = new Agent();
        $agent->setId(Uuid::v4());
        $agent->setShortBio('Descrição do agente');
        $agent->setLongBio('Descrição longa do agente');
        $agent->setCulture(true);

        $event->setCreatedBy($agent);

        $array = $event->toArray();
        $expectedArray = $agent->toArray();

        if ($expectedArray['organizations'] instanceof ArrayCollection) {
            $expectedArray['organizations'] = $expectedArray['organizations']->toArray();
        }
        if ($array['createdBy']['organizations'] instanceof ArrayCollection) {
            $array['createdBy']['organizations'] = $array['createdBy']['organizations']->toArray();
        }

        $this->assertSame($id->toRfc4122(), $array['id']);
        $this->assertSame('Festival', $array['name']);
        $this->assertSame($expectedArray, $array['createdBy']);
    }
}
