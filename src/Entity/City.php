<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: StateRepository::class)]
class City extends AbstractEntity
{

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[Groups(['city.get', 'state.get'])]
    private readonly Uuid $id;

    #[ORM\Column(length: 100)]
    #[Groups(['city.get', 'state.get'])]
    private readonly string $name;

    #[ORM\ManyToOne(targetEntity: State::class)]
    #[ORM\JoinColumn(name: 'state_id', referencedColumnName: 'id')]
    #[Groups(['city.get'])]
    private readonly State $state;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['city.get'])]
    private readonly ?int $cityCode;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function getCityCode(): ?int
    {
        return $this->cityCode;
    }
}
