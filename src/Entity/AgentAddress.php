<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AgentAddress extends Address
{
    #[ORM\ManyToOne(targetEntity: Agent::class, inversedBy: 'addresses')]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', nullable: false)]
    public Agent $owner {
        set {
            $this->owner = $value;
            $this->ownerType = 'agent';
        }
    }
}
