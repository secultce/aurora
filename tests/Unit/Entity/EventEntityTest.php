<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\ActivityArea;
use App\Entity\Agent;
use App\Entity\Event;
use App\Entity\Initiative;
use App\Entity\Space;
use App\Entity\Tag;
use App\Enum\AccessibilityInfoEnum;
use App\Enum\EventTypeEnum;
use App\Helper\DateFormatHelper;
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
        $coverImage = 'coverimage.jpg';
        $subtitle = 'subtitle';
        $shortDescription = 'shortdescription';
        $longDescription = 'longdescription';
        $type = EventTypeEnum::HYBRID->value;
        $endDate = new DateTime();
        $activityAreas = new ArrayCollection([
            new ActivityArea(),
            new ActivityArea(),
        ]);
        $tags = new ArrayCollection([
            new Tag(),
            new Tag(),
        ]);
        $site = 'evento.com';
        $phoneNumber = '0123456789';
        $maxCapacity = 100;
        $accessibleAudio = AccessibilityInfoEnum::YES->value;
        $accessibleLibras = AccessibilityInfoEnum::YES->value;
        $isFree = true;
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
        $event->setCoverImage($coverImage);
        $event->setSubtitle($subtitle);
        $event->setShortDescription($shortDescription);
        $event->setLongDescription($longDescription);
        $event->setType($type);
        $event->setEndDate($endDate);
        $event->setActivityAreas($activityAreas);
        $event->setTags($tags);
        $event->setSite($site);
        $event->setPhoneNumber($phoneNumber);
        $event->setMaxCapacity($maxCapacity);
        $event->setAccessibleAudio($accessibleAudio);
        $event->setAccessibleLibras($accessibleLibras);
        $event->setFree($isFree);
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
        $this->assertSame($coverImage, $event->getCoverImage());
        $this->assertSame($subtitle, $event->getSubtitle());
        $this->assertSame($shortDescription, $event->getShortDescription());
        $this->assertSame($longDescription, $event->getLongDescription());
        $this->assertSame($type, $event->getType());
        $this->assertSame($endDate, $event->getEndDate());
        $this->assertSame($activityAreas, $event->getActivityAreas());
        $this->assertSame($tags, $event->getTags());
        $this->assertSame($site, $event->getSite());
        $this->assertSame($phoneNumber, $event->getPhoneNumber());
        $this->assertSame($maxCapacity, $event->getMaxCapacity());
        $this->assertSame($accessibleAudio, $event->getAccessibleAudio());
        $this->assertSame($accessibleLibras, $event->getAccessibleLibras());
        $this->assertSame($isFree, $event->isFree());
        $this->assertSame($createdAt, $event->getCreatedAt());
        $this->assertSame($updatedAt, $event->getUpdatedAt());
        $this->assertSame($deletedAt, $event->getDeletedAt());
    }

    public function testToArray(): void
    {
        $event = new Event();

        $id = Uuid::v4();
        $name = 'Festival de Música';
        $image = 'image.jpg';

        $agent = new Agent();
        $agent->setId(Uuid::v4());
        $agent->setName('Agent test');
        $agent->setShortBio('Short Bio');
        $agent->setLongBio('Long Bio');
        $agent->setCulture(true);

        $space = new Space();
        $space->setId(Uuid::v4());
        $space->setName('Space test');
        $space->setMaxCapacity(100);
        $space->setIsAccessible(true);
        $space->setCreatedBy($agent);

        $initiative = new Initiative();
        $initiative->setId(Uuid::v4());
        $initiative->setName('Initiative test');
        $initiative->setCreatedBy($agent);

        $parentEvent = new Event();
        $parentEvent->setId(Uuid::v4());
        $parentEvent->setName('Parent Event test');
        $parentEvent->setCreatedBy($agent);
        $parentEvent->setEndDate(new DateTime());
        $parentEvent->setMaxCapacity(500);

        $extraFields = ['key' => 'value'];
        $createdBy = $agent;
        $coverImage = 'coverimage.jpg';
        $subtitle = 'subtitle';
        $shortDescription = 'shortdescription';
        $longDescription = 'longdescription';
        $type = EventTypeEnum::HYBRID->value;
        $endDate = new DateTime();
        $activityAreas = new ArrayCollection([
            new ActivityArea(),
            new ActivityArea(),
        ]);
        $tags = new ArrayCollection([
            new Tag(),
            new Tag(),
        ]);
        $site = 'evento.com';
        $phoneNumber = '0123456789';
        $maxCapacity = 100;
        $accessibleAudio = AccessibilityInfoEnum::YES->value;
        $accessibleLibras = AccessibilityInfoEnum::YES->value;
        $free = true;
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $deletedAt = new DateTime();

        $event->setId($id);
        $event->setName($name);
        $event->setImage($image);
        $event->setAgentGroup($agent);
        $event->setSpace($space);
        $event->setInitiative($initiative);
        $event->setParent($parentEvent);
        $event->setExtraFields($extraFields);
        $event->setCreatedBy($agent);
        $event->setCoverImage($coverImage);
        $event->setSubtitle($subtitle);
        $event->setShortDescription($shortDescription);
        $event->setLongDescription($longDescription);
        $event->setType($type);
        $event->setEndDate($endDate);
        $event->setActivityAreas($activityAreas);
        $event->setTags($tags);
        $event->setSite($site);
        $event->setPhoneNumber($phoneNumber);
        $event->setMaxCapacity($maxCapacity);
        $event->setAccessibleAudio($accessibleAudio);
        $event->setAccessibleLibras($accessibleLibras);
        $event->setFree($free);
        $event->setCreatedAt($createdAt);
        $event->setUpdatedAt($updatedAt);
        $event->setDeletedAt($deletedAt);

        $actualArray = $event->toArray();
        $expectedArray = [
            'id' => $id->toRfc4122(),
            'name' => $name,
            'agentGroup' => $agent->toArray(),
            'space' => $space->toArray(),
            'initiative' => $initiative->toArray(),
            'parent' => $parentEvent->toArray(),
            'createdBy' => $createdBy->toArray(),
            'coverImage' => $coverImage,
            'subtitle' => $subtitle,
            'shortDescription' => $shortDescription,
            'longDescription' => $longDescription,
            'type' => $type,
            'endDate' => $endDate->format(DateFormatHelper::DEFAULT_FORMAT),
            'activityAreas' => $activityAreas->toArray(),
            'tags' => $tags->toArray(),
            'site' => $site,
            'phoneNumber' => $phoneNumber,
            'maxCapacity' => $maxCapacity,
            'accessibleAudio' => $accessibleAudio,
            'accessibleLibras' => $accessibleLibras,
            'free' => $free,
            'createdAt' => $createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $updatedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
            'deletedAt' => $deletedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
        ];

        $this->assertSame($expectedArray, $actualArray);
    }
}
