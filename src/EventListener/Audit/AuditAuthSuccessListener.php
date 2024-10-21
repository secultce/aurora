<?php

declare(strict_types=1);

namespace App\EventListener\Audit;

use App\Document\AuthTimeline;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener(event: LoginSuccessEvent::class, priority: 4096)]
class AuditAuthSuccessListener extends AbstractAuditListener
{
    public function __construct(
        protected DocumentManager $documentManager,
        protected RequestStack $requestStack,
        protected Security $security,
    ) {
        parent::__construct($documentManager, $requestStack, $security);
    }

    public function __invoke(LoginSuccessEvent $event): void
    {
        $userId = $this->security->getUser()->getId()->toRfc4122();

        $document = new AuthTimeline();

        $document->setUserId($userId);
        $document->setPriority(1);
        $document->setDatetime(new DateTime());
        $document->setDevice($this->getDevice());
        $document->setPlatform($this->getPlatform());
        $document->setAction('login success');

        $this->documentManager->persist($document);
        $this->documentManager->flush();
    }
}
