<?php

declare(strict_types=1);

namespace App\DocumentService\Interface;

use Symfony\Component\Uid\Uuid;

interface TimelineDocumentServiceInterface
{
    public function getEventsByEntityId(Uuid $id): array;
}
