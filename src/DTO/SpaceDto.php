<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Agent;
use App\Entity\Space;
use App\Validator\Constraints\Exists;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class SpaceDto
{
    #[Sequentially([new NotBlank(), new Uuid()])]
    public mixed $id;

    #[Sequentially([new NotBlank(), new Type('string'), new Length(min: 2, max: 100)])]
    public mixed $name;

    #[Sequentially([new NotBlank(), new Uuid(), new Exists(Agent::class)])]
    public mixed $createdBy;

    #[Sequentially([new Uuid(), new Exists(Space::class)])]
    public mixed $parent;
}
