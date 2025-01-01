<?php

declare(strict_types=1);

namespace App\EventListener\Audit;

use App\DocumentService\AbstractTimelineDocumentService;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsDoctrineListener(event: Events::preUpdate, priority: 4096)]
class AuditUpdateListener extends AbstractAuditListener
{
    public function __construct(
        protected DocumentManager $documentManager,
        protected RequestStack $requestStack,
        protected Security $security
    ) {
        parent::__construct($documentManager, $requestStack, $security);
    }

    public function __invoke(PreUpdateEventArgs $args): void
    {
        $object = $args->getObject();
        $nameEntity = ($object)::class;
        $nameDocument = $this->resolveNameDocument($nameEntity);

        if (null === $nameDocument) {
            return;
        }

        $document = new $nameDocument();
        $userId = $this->security->getUser()->getId()->toRfc4122();
        $document->setTitle(AbstractTimelineDocumentService::UPDATED);
        $document->setUserId($userId);
        $document->setResourceId($object->getId()->toRfc4122());
        $document->setPriority(0);
        $document->setDatetime(new DateTime());
        $document->setDevice($this->getDevice());
        $document->setPlatform($this->getPlatform());
        $document->setFrom($object->toArray());
        $document->setTo($object->toArray());

        $this->documentManager->persist($document);
        $this->documentManager->flush();
    }
}
