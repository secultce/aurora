<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: StateRepository::class)]
class State extends AbstractEntity
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME)]
        #[Groups(['state.get'])]
        public readonly Uuid $id,
        #[ORM\Column(length: 100)]
        #[Groups(['state.get'])]
        public readonly string $name,
        #[ORM\Column(length: 2)]
        #[Groups(['state.get'])]
        public readonly string $acronym,
        #[ORM\OneToOne(targetEntity: City::class)]
        #[ORM\JoinColumn(name: 'capital_id', referencedColumnName: 'id')]
        #[Groups(['state.get'])]
        public readonly City $capital,
    ) {
    }
}
