<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\DateFormatHelper;
use App\Repository\EventRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['event.get', 'opportunity.get'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['event.get'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['event.get'])]
    private ?string $image = null;

    #[ORM\ManyToOne(targetEntity: Agent::class)]
    #[ORM\JoinColumn(name: 'agent_group_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    #[Groups(['event.get'])]
    private ?Agent $agentGroup = null;

    #[ORM\ManyToOne(targetEntity: Space::class)]
    #[ORM\JoinColumn(name: 'space_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    #[Groups(['event.get'])]
    private ?Space $space = null;

    #[ORM\ManyToOne(targetEntity: Initiative::class)]
    #[ORM\JoinColumn(name: 'initiative_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    #[Groups(['event.get'])]
    private ?Initiative $initiative = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    #[Groups(['event.get'])]
    private ?Event $parent = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups(['event.get.item'])]
    private ?array $extraFields = null;

    #[ORM\ManyToOne(targetEntity: Agent::class)]
    #[ORM\JoinColumn(name: 'created_by_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['event.get'])]
    private Agent $createdBy;

    #[ORM\Column]
    #[Groups(['event.get'])]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups(['event.get'])]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['event.get'])]
    private ?DateTime $deletedAt = null;

    /**
     * @var Collection<int, EventActivity>
     */
    #[ORM\OneToMany(targetEntity: EventActivity::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $eventActivities;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->eventActivities = new ArrayCollection();
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

    public function getAgentGroup(): ?Agent
    {
        return $this->agentGroup;
    }

    public function setAgentGroup(?Agent $agentGroup): void
    {
        $this->agentGroup = $agentGroup;
    }

    public function getSpace(): ?Space
    {
        return $this->space;
    }

    public function setSpace(?Space $space): void
    {
        $this->space = $space;
    }

    public function getInitiative(): ?Initiative
    {
        return $this->initiative;
    }

    public function setInitiative(?Initiative $initiative): void
    {
        $this->initiative = $initiative;
    }

    public function getCreatedBy(): Agent
    {
        return $this->createdBy;
    }

    public function setCreatedBy(Agent $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getParent(): ?Event
    {
        return $this->parent;
    }

    public function setParent(?Event $parent): void
    {
        $this->parent = $parent;
    }

    public function getExtraFields(): ?array
    {
        return $this->extraFields;
    }

    public function setExtraFields(?array $extraFields): void
    {
        $this->extraFields = $extraFields;
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

    public function getEventActivities(): Collection
    {
        return $this->eventActivities;
    }

    public function addEventActivity(EventActivity $eventActivity): void
    {
        if (false === $this->eventActivities->contains($eventActivity)) {
            return;
        }

        $this->eventActivities->add($eventActivity);
        $eventActivity->setEvent($this);
    }

    public function removeEventActivity(EventActivity $eventActivity): void
    {
        if (false === $this->eventActivities->removeElement($eventActivity)) {
            return;
        }

        if ($eventActivity->getEvent() === $this) {
            $eventActivity->setEvent(null);
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id?->toRfc4122(),
            'name' => $this->name,
            'agentGroup' => $this->agentGroup?->toArray(),
            'space' => $this->space?->toArray(),
            'initiative' => $this->initiative?->toArray(),
            'parent' => $this->parent?->toArray(),
            'createdBy' => $this->createdBy->toArray(),
            'createdAt' => $this->createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $this->updatedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
            'deletedAt' => $this->deletedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
        ];
    }
}
