<?php

declare(strict_types=1);

namespace App\EventListener\Audit;

use App\Document\AuthTimeline;
use App\Entity\User;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

#[AsEventListener(event: LoginFailureEvent::class, priority: 4096)]
class AuditAuthFailureListener extends AbstractAuditListener
{
    public function __construct(
        protected DocumentManager $documentManager,
        protected RequestStack $requestStack,
        protected Security $security,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct($documentManager, $requestStack, $security);
    }

    public function __invoke(LoginFailureEvent $event): void
    {
        $document = new AuthTimeline();

        $document->setAction('login failure');
        $document->setPriority(2);
        $document->setDatetime(new DateTime());
        $document->setDevice($this->getDevice());
        $document->setPlatform($this->getPlatform());

        if ('/login' === $this->requestStack->getCurrentRequest()->getPathInfo()) {
            return;
        }

        $email = $this->requestStack->getCurrentRequest()?->toArray()['username'] ?? null;

        $user = null;

        if (null !== $email) {
            /** @var User $user */
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        }

        if (null === $user) {
            $document->setAction('user not found');
        } else {
            $document->setUserId($user->getId()->toRfc4122());
        }

        $this->documentManager->persist($document);
        $this->documentManager->flush();
    }
}
