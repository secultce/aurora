<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\DateFormatHelper;
use App\Repository\SealEntityRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SealEntityRepository::class)]
class SealEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $entityId = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $entity = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $authorizedBy = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agent $createdBy = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getEntityId(): ?Uuid
    {
        return $this->entityId;
    }

    public function setEntityId(Uuid $entityId): void
    {
        $this->entityId = $entityId;
    }

    public function getEntity(): ?int
    {
        return $this->entity;
    }

    public function setEntity(int $entity): void
    {
        $this->entity = $entity;
    }

    public function getAuthorizedBy(): ?int
    {
        return $this->authorizedBy;
    }

    public function setAuthorizedBy(int $authorizedBy): void
    {
        $this->authorizedBy = $authorizedBy;
    }

    public function getCreatedBy(): Agent
    {
        return $this->createdBy;
    }

    public function setCreatedBy(Agent $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id?->toRfc4122(),
            'entityId' => $this->entityId->toRfc4122(),
            'authorizedBy' => $this->authorizedBy,
            'createdBy' => $this->createdBy->getId()->toRfc4122(),
            'createdAt' => $this->createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
        ];
    }
}
