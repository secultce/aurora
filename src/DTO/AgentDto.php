<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Organization;
use App\Validator\Constraints\Exists;
use App\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class AgentDto
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
        new NotNull(groups: [self::UPDATE]),
        new Type('string', groups: [self::CREATE, self::UPDATE]),
        new Length(max: 100, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $shortBio;

    #[Sequentially([
        new NotNull(groups: [self::UPDATE]),
        new Type('string', groups: [self::CREATE, self::UPDATE]),
        new Length(max: 255, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $longBio;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE, self::UPDATE]),
        new NotNull(groups: [self::UPDATE]),
        new Type('bool', groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $culture;

    #[Sequentially([
        new All([new Uuid()], [self::CREATE, self::UPDATE]),
        new Exists(Organization::class),
    ], groups: [self::CREATE, self::UPDATE])]
    public mixed $organizations;
}
