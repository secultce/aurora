<?php

declare(strict_types=1);

namespace App\DTO;

use App\Validator\Constraints\NotNull;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class FaqDto
{
    public const string CREATE = 'create';

    public const string UPDATE = 'update';

    #[Sequentially([new NotBlank(), new Uuid()], groups: [self::CREATE])]
    public mixed $id;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new NotNull(groups: [self::UPDATE]),
        new Type(Types::STRING, groups: [self::CREATE, self::UPDATE]),
        new Length(min: 2, max: 255, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $question;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new NotNull(groups: [self::UPDATE]),
        new Type(Types::STRING, groups: [self::CREATE, self::UPDATE]),
        new Length(min: 2, max: 255, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $answer;

    #[Sequentially([
        new Type(Types::BOOLEAN, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $active;
}
