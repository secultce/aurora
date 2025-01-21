<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\DateFormatHelper;
use App\Repository\InscriptionPhaseReviewRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InscriptionPhaseReviewRepository::class)]
class InscriptionPhaseReview
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['inscription-phase-review.get'])]
    private ?Uuid $id = null;

    #[ORM\OneToOne(targetEntity: InscriptionPhase::class)]
    #[ORM\JoinColumn(name: 'inscription_phase_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['inscription-phase-review.get'])]
    private ?InscriptionPhase $inscriptionPhase = null;

    #[ORM\OneToOne(targetEntity: Agent::class)]
    #[ORM\JoinColumn(name: 'reviewer_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['inscription-phase-review.get'])]
    private ?Agent $reviewer = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups(['inscription-phase-review.get'])]
    private ?array $result = null;

    #[ORM\Column]
    #[Groups('inscription-phase-review.get')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups('inscription-phase-review.get')]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups('inscription-phase-review.get')]
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

    public function getInscriptionPhase(): ?InscriptionPhase
    {
        return $this->inscriptionPhase;
    }

    public function setInscriptionPhase(?InscriptionPhase $inscriptionPhase): void
    {
        $this->inscriptionPhase = $inscriptionPhase;
    }

    public function getReviewer(): ?Agent
    {
        return $this->reviewer;
    }

    public function setReviewer(?Agent $reviewer): void
    {
        $this->reviewer = $reviewer;
    }

    public function getResult(): ?array
    {
        return $this->result;
    }

    public function setResult(?array $result): void
    {
        $this->result = $result;
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
            'inscriptionPhase' => $this->inscriptionPhase->getId(),
            'reviewer' => $this->reviewer->getId(),
            'result' => $this->result,
            'createdAt' => $this->createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $this->updatedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
            'deletedAt' => $this->deletedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
        ];
    }
}
