<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SpaceTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SpaceTypeRepository::class)]
class SpaceType extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['space.get', 'space.get.item'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 20)]
    #[Groups(['space.get', 'space.get.item'])]
    private ?string $name = null;

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

    public function toArray(): array
    {
        return [
            'id' => $this->id?->toRfc4122(),
            'name' => $this->name,
        ];
    }
}
