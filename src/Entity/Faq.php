<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\DateFormatHelper;
use App\Repository\FaqRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: FaqRepository::class)]
#[ORM\Table('faq')]
class Faq extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['faq.get'])]
    private ?Uuid $id = null;

    #[ORM\Column]
    #[Groups(['faq.get'])]
    private string $question;

    #[ORM\Column]
    #[Groups(['faq.get'])]
    private string $answer;

    #[ORM\Column]
    #[Groups(['faq.get'])]
    private bool $active = true;

    #[ORM\Column]
    #[Groups(['faq.get'])]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups(['faq.get'])]
    private ?DateTime $updatedAt = null;

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

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
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

    public function toArray(): array
    {
        return [
            'id' => $this->id?->toRfc4122(),
            'question' => $this->question,
            'answer' => $this->answer,
            'active' => $this->active,
            'createdAt' => $this->createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $this->updatedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
        ];
    }
}
