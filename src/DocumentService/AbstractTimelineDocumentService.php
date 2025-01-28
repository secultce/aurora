<?php

declare(strict_types=1);

namespace App\DocumentService;

use App\DocumentService\Interface\TimelineDocumentServiceInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Symfony\Component\Uid\Uuid;

abstract class AbstractTimelineDocumentService implements TimelineDocumentServiceInterface
{
    public const string CREATED = 'The resource was created';
    public const string DELETED = 'The resource was deleted';
    public const string UPDATED = 'The resource was updated';
    protected DocumentRepository $documentRepository;

    public function __construct(
        private readonly DocumentManager $documentManager,
        private readonly string $documentClass
    ) {
        $this->documentRepository = $this->documentManager->getRepository(
            $this->documentClass
        );
    }

    public function getEventsByEntityId(Uuid $id): array
    {
        return $this->documentRepository->findBy([
            'resourceId' => $id,
        ]);
    }
}
