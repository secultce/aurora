<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'agent_address')]
class AgentAddress extends Address
{
    #[ORM\ManyToOne(targetEntity: Agent::class, inversedBy: 'addresses')]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', nullable: false)]
    public Agent $owner;

    public function getOwner(): Agent
    {
        return $this->owner;
    }

    public function setOwner(Agent $owner): void
    {
        $this->owner = $owner;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['owner'] = $this->owner->getId()?->toRfc4122();

        return $data;
    }
}
