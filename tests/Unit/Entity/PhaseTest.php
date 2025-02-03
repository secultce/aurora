<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Agent;
use App\Entity\InscriptionPhase;
use App\Entity\Opportunity;
use App\Entity\Phase;
use App\Helper\DateFormatHelper;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Uid\Uuid;

class PhaseTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $phase = new Phase();

        $uuid = Uuid::v4();
        $phase->setId($uuid);
        $this->assertSame($uuid, $phase->getId());

        $phase->setName('Test Phase');
        $this->assertSame('Test Phase', $phase->getName());

        $phase->setDescription('This is a test phase.');
        $this->assertSame('This is a test phase.', $phase->getDescription());

        $startDate = new DateTime('2024-01-01 12:00:00');
        $endDate = new DateTime('2024-01-31 12:00:00');
        $phase->setStartDate($startDate);
        $phase->setEndDate($endDate);
        $this->assertSame($startDate, $phase->getStartDate());
        $this->assertSame($endDate, $phase->getEndDate());

        $phase->setStatus(true);
        $this->assertTrue($phase->isStatus());

        $phase->setSequence(2);
        $this->assertSame(2, $phase->getSequence());

        $agent = $this->createMock(Agent::class);
        $phase->setCreatedBy($agent);
        $this->assertSame($agent, $phase->getCreatedBy());

        $opportunity = $this->createMock(Opportunity::class);
        $phase->setOpportunity($opportunity);
        $this->assertSame($opportunity, $phase->getOpportunity());

        $criteria = ['key' => 'value'];
        $phase->setCriteria($criteria);
        $this->assertSame($criteria, $phase->getCriteria());

        $extraFields = ['field1' => 'value1'];
        $phase->setExtraFields($extraFields);
        $this->assertSame($extraFields, $phase->getExtraFields());

        $createdAt = new DateTimeImmutable('2024-01-01 10:00:00');
        $updatedAt = new DateTime('2024-02-01 10:00:00');
        $deletedAt = new DateTime('2024-03-01 10:00:00');

        $phase->setCreatedAt($createdAt);
        $phase->setUpdatedAt($updatedAt);
        $phase->setDeletedAt($deletedAt);

        $this->assertSame($createdAt, $phase->getCreatedAt());
        $this->assertSame($updatedAt, $phase->getUpdatedAt());
        $this->assertSame($deletedAt, $phase->getDeletedAt());

        $reviewer = $this->createMock(Agent::class);
        $phase->addReviewer($reviewer);
        $this->assertTrue($phase->getReviewers()->contains($reviewer));

        $phase->removeReviewer($reviewer);
        $this->assertFalse($phase->getReviewers()->contains($reviewer));
    }

    public function testInscriptionsMethods(): void
    {
        $phase = new Phase();
        $reflection = new ReflectionClass($phase);
        $property = $reflection->getProperty('inscriptions');
        $property->setAccessible(true);
        $property->setValue($phase, new ArrayCollection());

        $inscription = $this->createMock(InscriptionPhase::class);
        $phase->addInscription($inscription);

        $this->assertTrue($phase->getInscriptions()->contains($inscription));
    }

    public function testToArray(): void
    {
        $uuid = Uuid::v4();
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $deletedAt = new DateTime();

        $agent = $this->createMock(Agent::class);
        $agent->method('toArray')->willReturn(['id' => 'agent-id']);

        $opportunity = $this->createMock(Opportunity::class);
        $opportunity->method('toArray')->willReturn(['id' => 'opportunity-id']);

        $reviewer = $this->createMock(Agent::class);
        $reviewer->method('toArray')->willReturn(['id' => 'reviewer-id']);

        $phase = new Phase();
        $phase->setId($uuid);
        $phase->setName('Test Phase');
        $phase->setStatus(true);
        $phase->setSequence(1);
        $phase->setCreatedBy($agent);
        $phase->setOpportunity($opportunity);
        $phase->setCriteria(['criterion1' => 'value1']);
        $phase->setExtraFields(['extra1' => 'value2']);
        $phase->setCreatedAt($createdAt);
        $phase->setUpdatedAt($updatedAt);
        $phase->setDeletedAt($deletedAt);
        $phase->setReviewers(new ArrayCollection([$reviewer]));

        $expectedArray = [
            'id' => $uuid->toRfc4122(),
            'name' => 'Test Phase',
            'startDate' => $createdAt->format('Y-m-d H:i:s'),
            'endDate' => $createdAt->format('Y-m-d H:i:s'),
            'status' => true,
            'sequence' => 1,
            'createdBy' => ['id' => 'agent-id'],
            'opportunity' => ['id' => 'opportunity-id'],
            'reviewers' => [['id' => 'reviewer-id']],
            'criteria' => ['criterion1' => 'value1'],
            'extraFields' => ['extra1' => 'value2'],
            'createdAt' => $createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $updatedAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'deletedAt' => $deletedAt->format(DateFormatHelper::DEFAULT_FORMAT),
        ];

        $this->assertEquals($expectedArray, $phase->toArray());
    }
}
