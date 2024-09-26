<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\AgentDto;
use App\Entity\Agent;
use App\Exception\Agent\AgentResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\AgentRepositoryInterface;
use App\Service\Interface\AgentServiceInterface;
use DateTime;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class AgentService implements AgentServiceInterface
{
    private const DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private AgentRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function create(array $agent): Agent
    {
        $agentDto = $this->serializer->denormalize($agent, AgentDto::class);

        $violations = $this->validator->validate($agentDto, groups: AgentDto::CREATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $agentObj = $this->serializer->denormalize($agent, Agent::class);

        return $this->repository->save($agentObj);
    }

    public function get(Uuid $id): Agent
    {
        $agent = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $agent) {
            throw new AgentResourceNotFoundException();
        }

        return $agent;
    }

    public function list(): array
    {
        return $this->repository->findBy(
            self::DEFAULT_FILTERS,
            ['createdAt' => 'DESC']
        );
    }

    public function remove(Uuid $id): void
    {
        $agent = $this->get($id);
        $agent->setDeletedAt(new DateTime());

        $this->repository->save($agent);
    }

    public function update(Uuid $identifier, array $agent): Agent
    {
        $agentObj = $this->get($identifier);

        $agentDto = $this->serializer->denormalize($agent, AgentDto::class);

        $violations = $this->validator->validate($agentDto, groups: AgentDto::UPDATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $agentObj = $this->serializer->denormalize($agent, Agent::class, context: [
            'object_to_populate' => $agentObj,
        ]);

        $agentObj->setUpdatedAt(new DateTime());

        return $this->repository->save($agentObj);
    }
}
