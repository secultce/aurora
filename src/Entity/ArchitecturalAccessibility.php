<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class ArchitecturalAccessibility
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['space.get', 'space.get.item', 'architectural_accessibility.get', 'architectural_accessibility.get.item'])]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 50)]
    #[Groups(['space.get', 'space.get.item', 'architectural_accessibility.get', 'architectural_accessibility.get.item'])]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Groups(['space.get', 'space.get.item', 'architectural_accessibility.get', 'architectural_accessibility.get.item'])]
    private ?string $description = null;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toRfc4122(),
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
