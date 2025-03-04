<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Agent;
use App\Entity\Phase;
use App\Enum\InscriptionPhaseStatusEnum;
use App\Validator\Constraints\Exists;
use App\Validator\Constraints\NotNull;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class InscriptionPhaseDto
{
    public const string CREATE = 'create';

    public const string UPDATE = 'update';

    #[Sequentially([new NotBlank(), new Uuid()], groups: [self::CREATE])]
    public mixed $id;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new NotNull(groups: [self::UPDATE]),
        new Uuid(groups: [self::CREATE, self::UPDATE]),
        new Exists(Agent::class, groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $agent;

    #[Sequentially([
        new NotBlank(groups: [self::CREATE]),
        new Uuid(groups: [self::CREATE]),
        new Exists(Phase::class, groups: [self::CREATE]),
    ])]
    public mixed $phase;

    #[Sequentially([
        new Type(Types::STRING, groups: [self::CREATE, self::UPDATE]),
        new Choice(callback: [InscriptionPhaseStatusEnum::class, 'getNames'], groups: [self::CREATE, self::UPDATE]),
    ])]
    public mixed $status;
}
