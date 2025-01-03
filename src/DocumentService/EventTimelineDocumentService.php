<?php

declare(strict_types=1);

namespace App\DocumentService;

use App\Document\EventTimeline;
use App\DocumentService\Interface\TimelineDocumentServiceInterface;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Symfony\Component\Uid\Uuid;

final class EventTimelineDocumentService extends AbstractTimelineDocumentService implements TimelineDocumentServiceInterface
{
    public function getDocumentRepository(): DocumentRepository
    {
        return $this
            ->getDocumentManager()
            ->getRepository(EventTimeline::class);
    }

    public function getEventsByEntityId(Uuid $id): array
    {
        return $this->getDocumentRepository()->findBy([
            'resourceId' => $id,
        ]);
    }
}
