<?php

declare(strict_types=1);

namespace App\DocumentService;

use App\Document\UserTimeline;
use App\DocumentService\Interface\TimelineDocumentServiceInterface;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Uid\Uuid;

final class UserTimelineDocumentService extends AbstractTimelineDocumentService implements TimelineDocumentServiceInterface
{
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager, UserTimeline::class);
    }

    public function getLastLoginByUserId(Uuid $id): ?DateTime
    {
        $lastLogin = $this->documentRepository->findOneBy(
            [
                'resourceId' => $id,
                'action' => 'login',
            ],
            ['createdAt' => 'DESC']
        );

        return $lastLogin ? $lastLogin->getCreatedAt() : null;
    }
}
