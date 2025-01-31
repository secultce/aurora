<?php

declare(strict_types=1);

namespace App\DocumentService;

use App\Document\AuthTimeline;
use App\DocumentService\Interface\AuthTimelineDocumentServiceInterface;
use App\DocumentService\Interface\TimelineDocumentServiceInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Uid\Uuid;

class AuthTimelineDocumentService extends AbstractTimelineDocumentService implements TimelineDocumentServiceInterface, AuthTimelineDocumentServiceInterface
{
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager, AuthTimeline::class);
    }

    public function getTimelineLoginByUserId(Uuid $userId): array
    {
        return $this->documentRepository->findBy(
            ['userId' => $userId->toRfc4122()],
            ['datetime' => 'DESC'],
        );
    }
}
