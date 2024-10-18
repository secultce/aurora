<?php

declare(strict_types=1);

namespace App\EventListener\Audit;

use App\Document\AuthTimeline;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener(event: LoginSuccessEvent::class, priority: 4096)]
readonly class AuthSuccessListener
{
    public function __construct(
        private DocumentManager $documentManager,
        private Security $security,
    ) {
    }

    public function __invoke(LoginSuccessEvent $event): void
    {
        $userId = $this->security->getUser()->getId();

        $document = new AuthTimeline();
        $document->setUserId($userId);
        $document->setPriority(1);
        $document->setDatetime(new DateTime());
        $document->setDevice('dev');
        $document->setPlatform('dev');
        $document->setAction('login success');

        $this->documentManager->persist($document);
        $this->documentManager->flush();
    }
}
