<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Agent;
use App\Entity\Initiative;
use App\Entity\Space;
use App\Validator\Constraints\Exists;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class InitiativeDto
{
    public const string CREATE = 'create';

    #[Sequentially([new NotBlank(), new Uuid()], groups: [self::CREATE])]
    public mixed $id;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new Type('string', groups: [self::CREATE]),
        new Length(min: 2, max: 100, groups: [self::CREATE]),
    ])]
    public mixed $name;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new Uuid(groups: [self::CREATE]),
        new Exists(Agent::class, groups: [self::CREATE]),
    ])]
    public mixed $createdBy;

    #[Sequentially([new Uuid(), new Exists(Initiative::class)])]
    public mixed $parent;

    #[Sequentially([
        new Uuid(groups: [self::CREATE]),
        new Exists(Space::class, groups: [self::CREATE]),
    ])]
    public mixed $space;
}
