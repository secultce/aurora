<?php

declare(strict_types=1);

namespace App\DocumentService;

use App\Document\SpaceTimeline;
use App\DocumentService\Interface\TimelineDocumentServiceInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

class SpaceTimelineDocumentService extends AbstractTimelineDocumentService implements TimelineDocumentServiceInterface
{
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager, SpaceTimeline::class);
    }
}
