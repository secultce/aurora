<?php

declare(strict_types=1);

namespace App\DocumentService\Interface;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Symfony\Component\Uid\Uuid;

interface TimelineDocumentServiceInterface
{
    public function getDocumentRepository(): DocumentRepository;

    public function getEventsByEntityId(Uuid $id): array;
}
