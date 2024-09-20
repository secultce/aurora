<?php

declare(strict_types=1);

namespace App\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\Types\Type;
use Symfony\Component\Uid\Uuid;

#[ODM\Document(collection: 'initiative_timeline')]
class InitiativeTimeline
{
    #[ODM\Id]
    private ?string $id = null;

    #[ODM\Field]
    private Uuid $userId;

    #[ODM\Field]
    private Uuid $resourceId;

    #[ODM\Field]
    private int $priority;

    #[ODM\Field]
    private DateTime $datetime;

    #[ODM\Field]
    private string $device;

    #[ODM\Field]
    private string $platform;

    #[ODM\Field(type: Type::HASH)]
    private array $from;

    #[ODM\Field(type: Type::HASH)]
    private array $to;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): Uuid
    {
        return $this->userId;
    }

    public function setUserId(Uuid $userId): void
    {
        $this->userId = $userId;
    }

    public function getResourceId(): Uuid
    {
        return $this->resourceId;
    }

    public function setResourceId(Uuid $resourceId): void
    {
        $this->resourceId = $resourceId;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getDatetime(): DateTime
    {
        return $this->datetime;
    }

    public function setDatetime(DateTime $datetime): void
    {
        $this->datetime = $datetime;
    }

    public function getDevice(): string
    {
        return $this->device;
    }

    public function setDevice(string $device): void
    {
        $this->device = $device;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): void
    {
        $this->platform = $platform;
    }

    public function getFrom(): array
    {
        return $this->from;
    }

    public function setFrom(array $from): void
    {
        $this->from = $from;
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function setTo(array $to): void
    {
        $this->to = $to;
    }
}
