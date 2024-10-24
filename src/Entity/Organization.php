<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrganizationRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['agent.get', 'organization.get'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    #[Groups('organization.get')]
    private string $name;

    #[ORM\Column(nullable: true)]
    #[Groups('organization.get')]
    private ?string $description = null;

    #[ORM\JoinTable(name: 'organizations_agents')]
    #[ORM\JoinColumn(name: 'organization_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'agent_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Agent::class, inversedBy: 'organizations')]
    #[Groups('organization.get')]
    private Collection $agents;

    #[ORM\ManyToOne(targetEntity: Agent::class)]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, onDelete: 'SET NULL')]
    #[Groups('organization.get')]
    private Agent $owner;

    #[ORM\ManyToOne(targetEntity: Agent::class)]
    #[ORM\JoinColumn(name: 'created_by_id', referencedColumnName: 'id', nullable: false, onDelete: 'SET NULL')]
    #[Groups('organization.get')]
    private Agent $createdBy;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups(['organization.get.item'])]
    private ?array $extraFields = null;

    #[ORM\Column]
    #[Groups('organization.get')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups('organization.get')]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups('organization.get')]
    private ?DateTime $deletedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->agents = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function setAgents(Collection $agents): void
    {
        $this->agents = $agents;
    }

    public function addAgent(Agent $agent): void
    {
        $this->agents->add($agent);
    }

    public function getOwner(): Agent
    {
        return $this->owner;
    }

    public function setOwner(Agent $owner): void
    {
        $this->owner = $owner;
    }

    public function getCreatedBy(): Agent
    {
        return $this->createdBy;
    }

    public function setCreatedBy(Agent $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getExtraFields(): ?array
    {
        return $this->extraFields;
    }

    public function setExtraFields(?array $extraFields): void
    {
        $this->extraFields = $extraFields;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id?->toRfc4122(),
            'name' => $this->name,
            'description' => $this->description,
            'agents' => $this->agents->map(fn ($agent) => $agent->getId()->toRfc4122()),
            'owner' => $this->owner->toArray(),
            'createdBy' => $this->createdBy->toArray(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt?->format('Y-m-d H:i:s'),
            'deletedAt' => $this->deletedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
