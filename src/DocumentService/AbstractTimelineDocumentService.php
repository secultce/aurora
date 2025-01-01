<?php

declare(strict_types=1);

namespace App\DocumentService;

abstract class AbstractTimelineDocumentService
{
    public const string CREATED = 'The resource was created';
    public const string DELETED = 'The resource was deleted';
    public const string UPDATED = 'The resource was updated';
}
