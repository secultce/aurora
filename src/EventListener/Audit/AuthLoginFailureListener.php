<?php

declare(strict_types=1);

namespace App\EventListener\Audit;

use App\Document\AuthTimeline;
use App\Entity\User;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

#[AsEventListener(event: LoginFailureEvent::class, priority: 4096)]
readonly class AuthLoginFailureListener
{
    public function __construct(
        private DocumentManager $documentManager,
        private EntityManagerInterface $entityManager,
        private RequestStack $requestStack,
    ) {
    }

    public function __invoke(LoginFailureEvent $event): void
    {
        $document = new AuthTimeline();

        $email = $this->requestStack->getCurrentRequest()?->toArray()['username'] ?? null;

        if (false === is_null($email)) {
            /* @var User $user */
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            $document->setUserId($user->getId());
        }

        $document->setPriority(1);
        $document->setDatetime(new DateTime());
        $document->setDevice('dev');
        $document->setPlatform('dev');
        $document->setAction('login failure');

        $this->documentManager->persist($document);
        $this->documentManager->flush();
    }
}
