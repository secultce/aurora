<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\DateFormatHelper;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class EventSchedule
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $id;

    #[ORM\ManyToOne(inversedBy: 'eventSchedules')]
    #[ORM\JoinColumn]
    private ?Event $event = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $startHour;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $endHour = null;

    public function getId(): Uuid
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

    public function getStartHour(): DateTimeInterface
    {
        return $this->startHour;
    }

    public function setStartHour(DateTimeInterface $startHour): void
    {
        $this->startHour = $startHour;
    }

    public function getEndHour(): ?DateTimeInterface
    {
        return $this->endHour;
    }

    public function setEndHour(?DateTimeInterface $endHour): void
    {
        $this->endHour = $endHour;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toRfc4122(),
            'event' => $this->event?->toArray(),
            'startHour' => $this->startHour->format(DateFormatHelper::DEFAULT_FORMAT),
            'endHour' => $this->endHour?->format(DateFormatHelper::DEFAULT_FORMAT),
        ];
    }
}
