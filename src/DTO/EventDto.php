<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Agent;
use App\Entity\Event;
use App\Entity\Initiative;
use App\Entity\Space;
use App\Validator\Constraints\Exists;
use App\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class EventDto
{
    public const string CREATE = 'create';

    public const string UPDATE = 'update';

    #[Sequentially([new NotBlank(), new Uuid()], groups: [self::CREATE])]
    public mixed $id;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new NotNull(groups: [self::UPDATE]),
        new Type('string', groups: [self::CREATE, self::UPDATE]),
        new Length(min: 2, max: 100, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $name;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new Uuid(groups: [self::CREATE]),
        new Exists(Agent::class, groups: [self::CREATE]),
    ])]
    public mixed $agentGroup;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new Uuid(groups: [self::CREATE]),
        new Exists(Space::class, groups: [self::CREATE]),
    ])]
    public mixed $space;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new Uuid(groups: [self::CREATE]),
        new Exists(Initiative::class, groups: [self::CREATE]),
    ])]
    public mixed $initiative;

    #[Sequentially([
        new Uuid(groups: [self::CREATE]),
        new Exists(Event::class, groups: [self::CREATE]),
    ])]
    public mixed $parent;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new NotNull(groups: [self::UPDATE]),
        new Uuid(groups: [self::CREATE]),
        new Exists(Agent::class, groups: [self::CREATE]),
    ])]
    public mixed $createdBy;
}
