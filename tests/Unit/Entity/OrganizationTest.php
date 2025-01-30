<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Organization;
use App\Helper\DateFormatHelper;
use App\Tests\AbstractWebTestCase;
use App\Tests\Fixtures\AgentTestFixtures;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class OrganizationTest extends AbstractWebTestCase
{
    public function testGettersAndSettersFromOrganizationEntityShouldBeSuccessful(): void
    {
        $organization = new Organization();

        $id = Uuid::v4();
        $name = 'PHP com RAPadura';
        $description = 'Comunidade de devs PHP do Estado do Ceará';
        $image = 'phprapadura.jpg';
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $deletedAt = new DateTime();

        $agent1 = AgentTestFixtures::objectAgent();
        $agent2 = AgentTestFixtures::objectAgent();

        $owner = AgentTestFixtures::objectAgent();

        $createdBy = AgentTestFixtures::objectAgent();

        $extraFields = ['istagram' => '@phpcomrapadura', 'x' => 'phpcomrapadura'];

        $organization->setId($id);
        $organization->setName($name);
        $organization->setDescription($description);
        $organization->setImage($image);
        $organization->setCreatedAt($createdAt);
        $organization->setUpdatedAt($updatedAt);
        $organization->setDeletedAt($deletedAt);
        $organization->setOwner($owner);
        $organization->setCreatedBy($createdBy);
        $organization->setExtraFields($extraFields);

        $organization->addAgent($agent1);
        $organization->addAgent($agent2);

        $agents = $organization->getAgents();

        $this->assertSame($id, $organization->getId());
        $this->assertSame($name, $organization->getName());
        $this->assertSame($description, $organization->getDescription());
        $this->assertSame($image, $organization->getImage());
        $this->assertSame($createdAt, $organization->getCreatedAt());
        $this->assertSame($updatedAt, $organization->getUpdatedAt());
        $this->assertSame($deletedAt, $organization->getDeletedAt());
        $this->assertSame($owner, $organization->getOwner());
        $this->assertSame($createdBy, $organization->getCreatedBy());
        $this->assertSame($extraFields, $organization->getExtraFields());

        $this->assertCount(2, $organization->getAgents());

        $this->assertEquals([
            'id' => $id->toRfc4122(),
            'name' => $name,
            'description' => $description,
            'agents' => $agents->map(fn ($agent) => $agent->getId()->toRfc4122()),
            'owner' => $owner->toArray(),
            'createdBy' => $createdBy->toArray(),
            'createdAt' => $createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $updatedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
            'deletedAt' => $deletedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
        ], $organization->toArray());
    }
}
