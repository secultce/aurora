<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\DateFormatHelper;
use App\Repository\SpaceRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SpaceRepository::class)]
class Space extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['event.get', 'initiative.get', 'opportunity.get', 'space.get', 'activity-area.get'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    #[Groups('space.get')]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('space.get')]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('space.get')]
    private ?string $longDescription = null;

    #[ORM\Column(nullable: true)]
    #[Groups('space.get')]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('space.get')]
    private ?string $coverImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('space.get')]
    private ?string $site = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('space.get')]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups('space.get')]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('space.get')]
    private int $maxCapacity;

    #[ORM\Column(type: Types::BOOLEAN)]
    #[Groups('space.get')]
    private bool $isAccessible;

    #[ORM\OneToOne(targetEntity: SpaceAddress::class, mappedBy: 'owner', cascade: ['persist', 'remove'])]
    #[Groups('space.get')]
    private ?SpaceAddress $address = null;

    #[ORM\ManyToOne(targetEntity: Agent::class)]
    #[ORM\JoinColumn(name: 'created_by_id', referencedColumnName: 'id', nullable: false, onDelete: 'SET NULL')]
    #[Groups('space.get')]
    private Agent $createdBy;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    #[Groups('space.get')]
    #[MaxDepth(1)]
    private ?Space $parent = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups(['space.get.item'])]
    private ?array $extraFields = null;

    #[ORM\ManyToMany(targetEntity: ActivityArea::class, inversedBy: 'spaces', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'activity_area_spaces')]
    #[Groups(['space.get', 'space.get.item'])]
    private Collection $activityAreas;

    #[ORM\ManyToMany(targetEntity: Tag::class)]
    #[ORM\JoinTable(name: 'space_tags')]
    #[Groups(['space.get', 'space.get.item'])]
    private Collection $tags;

    #[ORM\Column]
    #[Groups('space.get')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups('space.get')]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups('space.get')]
    private ?DateTime $deletedAt = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->activityAreas = new ArrayCollection();
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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(?string $longDescription): void
    {
        $this->longDescription = $longDescription;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCreatedBy(): Agent
    {
        return $this->createdBy;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): void
    {
        $this->coverImage = $coverImage;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): void
    {
        $this->site = $site;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getMaxCapacity(): int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(int $maxCapacity): void
    {
        $this->maxCapacity = $maxCapacity;
    }

    public function getIsAccessible(): bool
    {
        return $this->isAccessible;
    }

    public function setIsAccessible(bool $isAccessible): void
    {
        $this->isAccessible = $isAccessible;
    }

    public function setCreatedBy(Agent $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getParent(): ?Space
    {
        return $this->parent;
    }

    public function setParent(?Space $parent): void
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

    public function getAddress(): ?SpaceAddress
    {
        return $this->address;
    }

    public function setAddress(SpaceAddress $address): void
    {
        $this->address = $address;
    }

    public function getActivityAreas(): Collection
    {
        return $this->activityAreas;
    }

    public function setActivityAreas(Collection $activityAreas): void
    {
        $this->activityAreas = $activityAreas;
    }

    public function addActivityArea(ActivityArea $activityArea): void
    {
        if (!$this->activityAreas->contains($activityArea)) {
            $this->activityAreas->add($activityArea);
        }
    }

    public function removeActivityArea(ActivityArea $activityArea): void
    {
        $this->activityAreas->removeElement($activityArea);
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function setTags(Collection $tags): void
    {
        $this->tags = $tags;
    }

    public function addTag(Tag $tag): void
    {
        if (false === $this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
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
            'shortDescription' => $this->shortDescription,
            'longDescription' => $this->longDescription,
            'image' => $this->image,
            'coverImage' => $this->coverImage,
            'site' => $this->site,
            'email' => $this->email,
            'phoneNumber' => $this->phoneNumber,
            'maxCapacity' => $this->maxCapacity,
            'isAccessible' => $this->isAccessible,
            'createdBy' => $this->createdBy->getId()->toRfc4122(),
            'parent' => $this->parent?->getId()->toRfc4122(),
            'address' => $this->address?->toArray(),
            'extraFields' => $this->extraFields,
            'activityAreas' => $this->activityAreas->map(fn (ActivityArea $activityArea) => $activityArea->toArray())->toArray(),
            'tags' => $this->tags->map(fn (Tag $tag) => $tag->toArray())->toArray(),
            'createdAt' => $this->createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $this->updatedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
            'deletedAt' => $this->deletedAt?->format(DateFormatHelper::DEFAULT_FORMAT),
        ];
    }
}
