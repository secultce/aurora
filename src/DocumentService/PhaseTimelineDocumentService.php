<?php

declare(strict_types=1);

namespace App\DocumentService;

use App\Document\PhaseTimeline;
use App\DocumentService\Interface\TimelineDocumentServiceInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

final class PhaseTimelineDocumentService extends AbstractTimelineDocumentService implements TimelineDocumentServiceInterface
{
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager, PhaseTimeline::class);
    }
}
