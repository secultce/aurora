<?php

declare(strict_types=1);

namespace App\DTO;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class EventActivityDto
{
    public const CREATE = 'create';
    public const UPDATE = 'update';

    #[Sequentially([new NotBlank(), new Uuid()], groups: [self::CREATE])]
    public mixed $id;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new Type(Types::STRING, groups: [self::CREATE, self::UPDATE]),
        new Length(min: 2, max: 100, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $title;

    #[Sequentially([
        new Type(type: Types::STRING, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $description;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new DateTime(format: DateTimeInterface::ATOM, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $startDate;

    #[Sequentially([
        new DateTime(format: DateTimeInterface::ATOM, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $endDate;
}
