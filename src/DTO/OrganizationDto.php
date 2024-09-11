<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Agent;
use App\Validator\Constraints\Exists;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class OrganizationDto
{
    #[Sequentially([new NotBlank(), new Uuid()])]
    public mixed $id;

    #[Sequentially([new NotBlank(), new Type('string'), new Length(min: 2, max: 100)])]
    public mixed $name;

    #[Sequentially([new Type('string'), new Length(max: 255)])]
    public mixed $description;

    #[Sequentially([new NotBlank(), new Uuid(), new Exists(Agent::class)])]
    public mixed $createdBy;

    #[Sequentially([new NotBlank(), new Uuid(), new Exists(Agent::class)])]
    public mixed $owner;

    #[Sequentially([new All([new Uuid()]), new Exists(Agent::class)])]
    public mixed $agents = [];
}
