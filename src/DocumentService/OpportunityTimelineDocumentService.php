<?php

declare(strict_types=1);

namespace App\DocumentService;

use App\Document\OpportunityTimeline;
use App\DocumentService\Interface\TimelineDocumentServiceInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

final class OpportunityTimelineDocumentService extends AbstractTimelineDocumentService implements TimelineDocumentServiceInterface
{
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager, OpportunityTimeline::class);
    }
}
