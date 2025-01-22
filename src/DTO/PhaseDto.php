<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Opportunity;
use App\Validator\Constraints\Exists;
use App\Validator\Constraints\Json;
use App\Validator\Constraints\NotNull;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class PhaseDto
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
        new Type('string', groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $description;

    #[Sequentially([
        new Type(Types::STRING, groups: [self::CREATE, self::UPDATE]),
        new Date(groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $startDate;

    #[Sequentially([
        new Type(Types::STRING, groups: [self::CREATE, self::UPDATE]),
        new Date(groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $endDate;

    #[Sequentially([
        new NotNull(groups: [self::CREATE, self::UPDATE]),
        new Type(Types::BOOLEAN, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $status;

    #[Sequentially([
        new NotNull(groups: [self::CREATE, self::UPDATE]),
        new Type(Types::INTEGER, groups: [self::CREATE, self::UPDATE]),
        new Positive(groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $sequence;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new NotNull(groups: [self::CREATE, self::UPDATE]),
        new Uuid(groups: [self::CREATE, self::UPDATE]),
        new Exists(Opportunity::class, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $opportunity;

    #[Sequentially([new Json(groups: [self::CREATE, self::UPDATE])])]
    public mixed $extraFields;
}
