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

final class SpaceTypeDto
{
    public const string CREATE = 'create';

    public const string UPDATE = 'update';

    #[Sequentially([new NotBlank(), new Uuid()], groups: [self::CREATE])]
    public mixed $id;

    #[Sequentially([
        new NotBlank(),
        new NotNull(),
        new Type(Types::STRING),
        new Length(min: 2, max: 20),
    ], groups: [self::CREATE, self::UPDATE])]
    public mixed $name;
}
