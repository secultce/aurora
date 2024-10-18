<?php

declare(strict_types=1);

namespace App\EventListener\Audit;

use App\Document\AgentTimeline;
use App\Document\EventTimeline;
use App\Document\InitiativeTimeline;
use App\Document\OpportunityTimeline;
use App\Document\SpaceTimeline;
use App\Document\UserTimeline;
use App\Entity\Agent;
use App\Entity\Event;
use App\Entity\Initiative;
use App\Entity\Opportunity;
use App\Entity\Space;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsDoctrineListener(event: Events::preUpdate, priority: 4096)]
readonly class AuditUpdateListener
{
    public function __construct(
        private DocumentManager $documentManager,
        private Security $security,
    ) {
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
        $userId = $this->security->getUser()->getId();
        $document->setUserId($userId);
        $document->setResourceId($object->getId());
        $document->setPriority(0);
        $document->setDatetime(new DateTime());
        $document->setDevice('web');
        $document->setPlatform('web');
        $document->setFrom($object->toArray());
        $document->setTo($object->toArray());

        $this->documentManager->persist($document);
        $this->documentManager->flush();
    }

    private function resolveNameDocument(string $class): ?string
    {
        return match ($class) {
            Agent::class => AgentTimeline::class,
            Event::class => EventTimeline::class,
            Initiative::class => InitiativeTimeline::class,
            Opportunity::class => OpportunityTimeline::class,
            Space::class => SpaceTimeline::class,
            User::class => UserTimeline::class,
            default => null,
        };
    }
}
