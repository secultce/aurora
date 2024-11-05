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
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME)]
        #[Groups(['city.get', 'state.get'])]
        public readonly Uuid $id,
        #[ORM\Column(length: 100)]
        #[Groups(['city.get', 'state.get'])]
        public readonly string $name,
        #[ORM\ManyToOne(targetEntity: State::class)]
        #[ORM\JoinColumn(name: 'state_id', referencedColumnName: 'id')]
        #[Groups(['city.get'])]
        public readonly State $state,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        #[Groups(['city.get'])]
        public readonly ?int $cityCode,
    ) {
    }
}
