<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Agent;
use App\Entity\Event;
use App\Entity\Initiative;
use App\Entity\Opportunity;
use App\Entity\Phase;
use App\Entity\Space;
use App\Helper\DateFormatHelper;
use App\Tests\AbstractWebTestCase;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Uid\Uuid;

class OpportunityTest extends AbstractWebTestCase
{
    public function testGettersAndSettersFromOpportunityShouldBeSuccessful(): void
    {
        $opportunity = new Opportunity();

        $this->assertNull($opportunity->getId());
        $this->assertNull($opportunity->getImage());
        $this->assertNull($opportunity->getName());
        $this->assertNull($opportunity->getParent());
        $this->assertNull($opportunity->getSpace());
        $this->assertNull($opportunity->getInitiative());
        $this->assertNull($opportunity->getEvent());
        $this->assertNull($opportunity->getExtraFields());
        $this->assertCount(0, $opportunity->getPhases());
        $this->assertInstanceOf(ArrayCollection::class, $opportunity->getPhases());
        $this->assertInstanceOf(DateTimeImmutable::class, $opportunity->getCreatedAt());
        $this->assertNull($opportunity->getUpdatedAt());
        $this->assertNull($opportunity->getDeletedAt());

        $id = Uuid::v4();
        $name = 'Opportunity One';
        $image = 'opportunity_image.jpg';
        $parent = new Opportunity();
        $space = new Space();
        $initiative = new Initiative();
        $event = new Event();
        $createdBy = new Agent();
        $phase = new Phase();
        $extrafields = ['key' => 'value'];
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $deletedAt = new DateTime();

        $opportunity->setId($id);
        $opportunity->setName($name);
        $opportunity->setImage($image);
        $opportunity->setParent($parent);
        $opportunity->setSpace($space);
        $opportunity->setInitiative($initiative);
        $opportunity->setEvent($event);
        $opportunity->setCreatedBy($createdBy);
        $opportunity->setExtraFields($extrafields);
        $opportunity->setCreatedAt($createdAt);
        $opportunity->setUpdatedAt($updatedAt);
        $opportunity->setDeletedAt($deletedAt);

        $this->assertEquals($id, $opportunity->getId());
        $this->assertEquals($name, $opportunity->getName());
        $this->assertEquals($image, $opportunity->getImage());
        $this->assertEquals($parent, $opportunity->getParent());
        $this->assertEquals($space, $opportunity->getSpace());
        $this->assertEquals($initiative, $opportunity->getInitiative());
        $this->assertEquals($event, $opportunity->getEvent());
        $this->assertEquals($createdBy, $opportunity->getCreatedBy());
        $this->assertEquals($extrafields, $opportunity->getExtraFields());

        $opportunity->addPhase($phase);
        $this->assertCount(1, $opportunity->getPhases());
        $this->assertTrue($opportunity->getPhases()->contains($phase));

        $opportunity->removePhase($phase);
        $this->assertCount(0, $opportunity->getPhases());
        $this->assertFalse($opportunity->getPhases()->contains($phase));

        $opportunity->setPhases(new ArrayCollection([$phase, new Phase()]));
        $this->assertCount(2, $opportunity->getPhases());
        $this->assertTrue($opportunity->getPhases()->contains($phase));

        $opportunity->setPhases(new ArrayCollection([$space, $phase, $phase]));
        $this->assertCount(1, $opportunity->getPhases());
        $this->assertFalse($opportunity->getPhases()->contains($space));

        $this->assertEquals($createdAt, $opportunity->getCreatedAt());
        $this->assertEquals($updatedAt, $opportunity->getUpdatedAt());
        $this->assertEquals($deletedAt, $opportunity->getDeletedAt());

        $parent->setId(Uuid::v4());
        $parent->setName('Parent Opportunity One');
        $parent->setCreatedBy($createdBy);

        $space->setId(Uuid::v4());
        $space->setName('Space One');
        $space->setCreatedBy($createdBy);

        $initiative->setId(Uuid::v4());
        $initiative->setName('Initiative One');
        $initiative->setCreatedBy($createdBy);

        $event->setId(Uuid::v4());
        $event->setName('Event Name');
        $event->setCreatedBy($createdBy);

        $createdBy->setId(Uuid::v4());
        $createdBy->setName('Agent Name');
        $createdBy->setShortBio('Short Bio');
        $createdBy->setLongBio('Long Bio');
        $createdBy->setCulture(true);

        $expectedArray = [
            'id' => $id->toRfc4122(),
            'name' => $name,
            'parent' => $parent->toArray(),
            'space' => $space->toArray(),
            'initiative' => $initiative->toArray(),
            'event' => $event->toArray(),
            'image' => $image,
            'createdBy' => $createdBy->toArray(),
            'createdAt' => $createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $updatedAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'deletedAt' => $deletedAt->format(DateFormatHelper::DEFAULT_FORMAT),
        ];

        $this->assertEquals($expectedArray, $opportunity->toArray());
    }

    public function testAddDuplicatePhaseShouldNotBeAdded(): void
    {
        $opportunity = new Opportunity();
        $phase = new Phase();

        $opportunity->addPhase($phase);
        $opportunity->addPhase($phase);

        $this->assertCount(1, $opportunity->getPhases());
    }
}
