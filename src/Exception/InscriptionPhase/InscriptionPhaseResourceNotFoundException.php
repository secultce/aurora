<?php

declare(strict_types=1);

namespace App\Exception\InscriptionPhase;

use App\Exception\ResourceNotFoundException;

class InscriptionPhaseResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'InscriptionPhase';
}
