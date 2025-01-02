<?php

declare(strict_types=1);

namespace App\DocumentService;

use Doctrine\ODM\MongoDB\DocumentManager;

abstract class AbstractTimelineDocumentService
{
    public const string CREATED = 'The resource was created';
    public const string DELETED = 'The resource was deleted';
    public const string UPDATED = 'The resource was updated';

    public function __construct(
        private DocumentManager $documentManager,
    ) {
    }

    public function getDocumentManager(): DocumentManager
    {
        return $this->documentManager;
    }
}
