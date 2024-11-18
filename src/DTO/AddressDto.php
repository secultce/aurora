<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Agent;
use App\Entity\City;
use App\Entity\Space;
use App\Validator\Constraints\Exists;
use App\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\AtLeastOneOf;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class AddressDto
{
    public const string CREATE = 'create';

    public const string UPDATE = 'update';

    #[Sequentially([new NotBlank(), new Uuid()], groups: [self::CREATE])]
    public mixed $id;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new NotNull(groups: [self::UPDATE]),
        new Type(type: 'string', groups: [self::CREATE, self::UPDATE]),
        new Length(min: 5, max: 100),
    ])]
    public mixed $street;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new NotNull(groups: [self::UPDATE]),
        new Type(type: 'string', groups: [self::CREATE, self::UPDATE]),
        new Length(min: 1, max: 5),
    ])]
    public mixed $number;

    #[Sequentially([new Type(type: 'string'), new Length(min: 5, max: 100)], groups: [self::CREATE, self::UPDATE])]
    public mixed $complement;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new NotNull(groups: [self::UPDATE]),
        new Type(type: 'string', groups: [self::CREATE, self::UPDATE]),
        new Length(min: 2, max: 50),
    ])]
    public mixed $neighborhood;

    #[Sequentially([
        new NotNull(groups: [self::UPDATE]),
        new NotBlank(groups: [self::CREATE]),
        new Uuid(groups: [self::CREATE, self::UPDATE]),
        new Exists(City::class, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $city;

    #[Sequentially([
        new NotNull(groups: [self::UPDATE]),
        new NotBlank(groups: [self::CREATE]),
        new Type(type: 'string', groups: [self::CREATE, self::UPDATE]),
        new Length(min: 8, max: 8),
    ])]
    public mixed $zipcode;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new Uuid(groups: [self::CREATE]),
        new AtLeastOneOf([
            new Exists(entity: Agent::class),
            new Exists(entity: Space::class),
        ], groups: [self::CREATE]),
    ])]
    public mixed $owner;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new Choice(choices: ['agent', 'space'], message: 'The owner type must be "agent" or "space"'),
    ], groups: [self::CREATE, self::UPDATE])]
    public mixed $ownerType;
}
