<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\InscriptionOpportunityStatus;
use App\Repository\InscriptionOpportunityRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InscriptionOpportunityRepository::class)]
class InscriptionOpportunity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['inscription_opportunity.get'])]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: Agent::class)]
    #[ORM\JoinColumn(name: 'agent_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['inscription_opportunity.get'])]
    private ?Agent $agent = null;

    #[ORM\ManyToOne(targetEntity: Opportunity::class, inversedBy: 'phases')]
    #[ORM\JoinColumn(name: 'opportunity_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['inscription_opportunity.get'])]
    private ?Opportunity $opportunity = null;

    #[ORM\Column]
    #[Groups(['inscription_opportunity.get'])]
    private ?InscriptionOpportunityStatus $status = null;

    #[ORM\Column]
    #[Groups('inscription_opportunity.get')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups('inscription_opportunity.get')]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups('inscription_opportunity.get')]
    private ?DateTime $deletedAt = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): ?InscriptionOpportunityStatus
    {
        return $this->status;
    }

    public function setStatus(InscriptionOpportunityStatus $status): void
    {
        $this->status = $status;
    }

    public function getAgent(): Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): void
    {
        $this->agent = $agent;
    }

    public function getOpportunity(): ?Opportunity
    {
        return $this->opportunity;
    }

    public function setOpportunity(?Opportunity $opportunity): void
    {
        $this->opportunity = $opportunity;
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
            'agent' => $this->agent->toArray(),
            'opportunity' => $this->getOpportunity()->toArray(),
            'status' => $this->status->value,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt?->format('Y-m-d H:i:s'),
            'deletedAt' => $this->deletedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
