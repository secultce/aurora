<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\DateFormatHelper;
use App\Repository\SealRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SealRepository::class)]
class Seal extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['seal.get'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['seal.get'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['seal.get'])]
    private ?string $description = null;
    #[ORM\Column]
    #[Groups(['seal.get'])]
    private bool $active = false;

    #[ORM\ManyToOne(targetEntity: Agent::class, inversedBy: 'seals')]
    #[ORM\JoinColumn(name: 'created_by_id', referencedColumnName: 'id', nullable: false, onDelete: 'SET NULL')]
    #[Groups('seal.get')]
    private Agent $createdBy;

    #[ORM\Column(nullable: true)]
    #[Groups(['seal.get'])]
    private DateTimeImmutable $expirationDate;

    #[ORM\Column]
    #[Groups(['seal.get'])]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups(['seal.get'])]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['seal.get'])]
    private ?DateTime $deletedAt = null;

    public function __construct()
    {
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

    public function setName(string $name): ?string
    {
        return $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatedBy(): Agent
    {
        return $this->createdBy;
    }

    public function setCreatedBy(Agent $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getExpirationDate(): DateTimeImmutable
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(DateTimeImmutable $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
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
            'active' => $this->active,
            'createdBy' => $this->createdBy->getId()->toRfc4122(),
            'expirationDate' => $this->expirationDate?->format('Y-m-d H:i:s'),
            'createdAt' => $this->createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $this->updatedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
            'deletedAt' => $this->deletedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
        ];
    }
}
