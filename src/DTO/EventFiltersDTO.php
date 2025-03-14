<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\City;
use App\Validator\Constraints\Exists;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Constraints\AtLeastOneOf;

class EventFiltersDTO
{
    public const string VALIDATE = 'validate';

    #[Sequentially([
        new NotBlank(allowNull: true),
        new Type('string'),
    ], groups: [self::VALIDATE])]
    public mixed $name;

    #[Sequentially([
        new All([
            new AtLeastOneOf([
                new Type('string'),
                new Type(\DateTimeInterface::class),
            ], groups: [self::VALIDATE]),
        ], groups: [self::VALIDATE]),
    ])]
    public mixed $period;

    #[Sequentially([
        new Type('bool'),
    ], groups: [self::VALIDATE])]
    public mixed $officialEvents;

    #[Sequentially([
        new Type('string'),
    ], groups: [self::VALIDATE])]
    public mixed $language;

    #[Sequentially([
        new Type('string'),
    ], groups: [self::VALIDATE])]
    public mixed $ageRating;

    #[Sequentially([
        new Uuid(),
        new Exists(Seal::class, groups: [self::VALIDATE]),
    ], groups: [self::VALIDATE])]
    public mixed $seals;

    #[Sequentially([
        new Uuid(),
        new Exists(State::class, groups: [self::VALIDATE]),
    ], groups: [self::VALIDATE])]
    public mixed $state;

    #[Sequentially([
        new Uuid(),
        new Exists(City::class, groups: [self::VALIDATE]),
    ], groups: [self::VALIDATE])]
    public mixed $city;
}
