<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AgentRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['agent.get', 'event.get', 'initiative.get', 'opportunity.get', 'space.get', 'user.get', 'organization.get'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['agent.get'])]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['agent.get'])]
    private ?string $image = null;

    #[ORM\Column(length: 100)]
    #[Groups(['agent.get'])]
    private string $shortBio;

    #[ORM\Column(length: 255)]
    #[Groups(['agent.get'])]
    private string $longBio;

    #[ORM\Column(length: 100)]
    #[Groups(['agent.get'])]
    private bool $culture;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups(['agent.get.item'])]
    private ?array $extraFields = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[Groups('agent.get')]
    #[MaxDepth(1)]
    private User $user;

    #[ORM\ManyToMany(targetEntity: Organization::class, mappedBy: 'agents')]
    #[Groups(['agent.get'])]
    private Collection $organizations;

    #[ORM\Column]
    #[Groups(['agent.get'])]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups(['agent.get'])]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['agent.get'])]
    private ?DateTime $deletedAt = null;

    public function __construct()
    {
        $this->organizations = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getShortBio(): string
    {
        return $this->shortBio;
    }

    public function setShortBio(string $shortBio): void
    {
        $this->shortBio = $shortBio;
    }

    public function getLongBio(): string
    {
        return $this->longBio;
    }

    public function setLongBio(string $longBio): void
    {
        $this->longBio = $longBio;
    }

    public function isCulture(): bool
    {
        return $this->culture;
    }

    public function setCulture(bool $culture): void
    {
        $this->culture = $culture;
    }

    public function getExtraFields(): ?array
    {
        return $this->extraFields;
    }

    public function setExtraFields(?array $extraFields): void
    {
        $this->extraFields = $extraFields;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function setOrganizations(Collection $organizations): void
    {
        $this->organizations = $organizations;
    }

    public function addOrganization(Organization $organization): void
    {
        $this->organizations->add($organization);
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
}
