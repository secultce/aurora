<?php

declare(strict_types=1);

namespace App\EventListener\Audit;

use App\Document\AgentTimeline;
use App\Document\EventTimeline;
use App\Document\InitiativeTimeline;
use App\Document\OpportunityTimeline;
use App\Document\OrganizationTimeline;
use App\Document\PhaseTimeline;
use App\Document\SpaceTimeline;
use App\Document\UserTimeline;
use App\Entity\Agent;
use App\Entity\Event;
use App\Entity\Initiative;
use App\Entity\Opportunity;
use App\Entity\Organization;
use App\Entity\Phase;
use App\Entity\Space;
use App\Entity\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractAuditListener
{
    public const string UNKNOWN = 'unknown';

    public function __construct(
        protected DocumentManager $documentManager,
        protected RequestStack $requestStack,
        protected Security $security,
    ) {
    }

    protected function getDevice(): string
    {
        return self::UNKNOWN;
    }

    protected function getPlatform(): string
    {
        if (null === $this->requestStack->getCurrentRequest()) {
            return self::UNKNOWN;
        }

        return $this->isApiRequest() ? 'api' : 'web';
    }

    protected function isApiRequest(): ?bool
    {
        return str_starts_with($this->requestStack->getCurrentRequest()->getPathInfo(), '/api');
    }

    protected function resolveNameDocument(string $class): ?string
    {
        return match ($class) {
            Agent::class => AgentTimeline::class,
            Event::class => EventTimeline::class,
            Initiative::class => InitiativeTimeline::class,
            Opportunity::class => OpportunityTimeline::class,
            Organization::class => OrganizationTimeline::class,
            Phase::class => PhaseTimeline::class,
            Space::class => SpaceTimeline::class,
            User::class => UserTimeline::class,
            default => null,
        };
    }
}
