<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bundle\SecurityBundle\Security;

abstract readonly class AbstractEntityService
{
    private const array DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private Security $security,
    ) {
    }

    public function getDefaultParams(): array
    {
        return self::DEFAULT_FILTERS;
    }

    public function getUserParams(): array
    {
        $params = self::DEFAULT_FILTERS;

        if (null !== $this->security->getUser()) {
            $agents = $this->security->getUser()->getAgents()->getValues();

            $params['createdBy'] = $agents;
        }

        return $params;
    }
}
