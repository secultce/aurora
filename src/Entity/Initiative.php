<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\InitiativeRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InitiativeRepository::class)]
class Initiative extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['initiative.get', 'opportunity.get'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    #[Groups('initiative.get')]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    #[Groups('initiative.get')]
    #[MaxDepth(1)]
    private ?Initiative $parent = null;

    #[ORM\ManyToOne(targetEntity: Space::class)]
    #[ORM\JoinColumn(name: 'space_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    #[Groups('initiative.get')]
    private ?Space $space = null;

    #[ORM\ManyToOne(targetEntity: Agent::class)]
    #[ORM\JoinColumn(name: 'created_by_id', referencedColumnName: 'id', nullable: false, onDelete: 'SET NULL')]
    #[Groups('initiative.get')]
    private Agent $createdBy;

    #[ORM\Column]
    #[Groups('initiative.get')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups('initiative.get')]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups('initiative.get')]
    private ?DateTime $deletedAt = null;

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

    public function getParent(): ?Initiative
    {
        return $this->parent;
    }

    public function setParent(?Initiative $parent): void
    {
        $this->parent = $parent;
    }

    public function getSpace(): ?Space
    {
        return $this->space;
    }

    public function setSpace(?Space $space): void
    {
        $this->space = $space;
    }

    public function getCreatedBy(): Agent
    {
        return $this->createdBy;
    }

    public function setCreatedBy(Agent $createdBy): void
    {
        $this->createdBy = $createdBy;
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
