<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\DateFormatHelper;
use App\Repository\EventActivityRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: EventActivityRepository::class)]
class EventActivity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['event-activity.get'])]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'eventActivities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['event-activity.get'])]
    private ?Event $event = null;

    #[ORM\Column(length: 100)]
    #[Groups(['event-activity.get'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['event-activity.get'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['event-activity.get'])]
    private ?DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['event-activity.get'])]
    private ?DateTimeInterface $endDate = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): void
    {
        $this->event = $event;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id?->toRfc4122(),
            'event' => $this->event->toArray(),
            'title' => $this->title,
            'description' => $this->description,
            'startDate' => $this->startDate->format(DateFormatHelper::DEFAULT_FORMAT),
            'endDate' => $this->endDate?->format(DateFormatHelper::DEFAULT_FORMAT),
        ];
    }
}
