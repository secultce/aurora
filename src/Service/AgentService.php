<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\AgentDto;
use App\Entity\Agent;
use App\Exception\Agent\AgentResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\AgentRepositoryInterface;
use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\FileServiceInterface;
use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class AgentService extends AbstractEntityService implements AgentServiceInterface
{
    private const array DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private AgentRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private FileServiceInterface $fileService,
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function create(array $agent): Agent
    {
        $agent = self::validateInput($agent, AgentDto::CREATE);

        $agentObj = $this->serializer->denormalize($agent, Agent::class);

        return $this->repository->save($agentObj);
    }

    public function createFromUser(array $user): void
    {
        $agent = self::organizeDefaultAgentData($user);
        $agent = self::validateInput($agent, AgentDto::CREATE);

        $agentObj = $this->serializer->denormalize($agent, Agent::class);

        $this->repository->save($agentObj);
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

    public function list(array $filters = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            array_merge($filters, self::DEFAULT_FILTERS),
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function count(): int
    {
        return $this->repository->count(
            $this->getDefaultParams()
        );
    }

    public function remove(Uuid $id): void
    {
        $agent = $this->get($id);
        $agent->setDeletedAt(new DateTime());

        $this->repository->save($agent);
    }

    public function update(Uuid $id, array $agent): Agent
    {
        $agentObj = $this->get($id);

        $agent = self::validateInput($agent, AgentDto::UPDATE);

        $agentObj = $this->serializer->denormalize($agent, Agent::class, context: [
            'object_to_populate' => $agentObj,
        ]);

        $agentObj->setUpdatedAt(new DateTime());

        return $this->repository->save($agentObj);
    }

    private function validateInput(array $agent, string $group): array
    {
        $agentDto = self::denormalizeDto($agent);

        $violations = $this->validator->validate($agentDto, groups: $group);

        if ($violations->count() > 0) {
            if ($agentDto->image instanceof File) {
                $this->fileService->deleteFile($agentDto->image->getRealPath());
            }

            throw new ValidatorException(violations: $violations);
        }

        if ($agentDto->image instanceof File) {
            $agent = array_merge($agent, ['image' => $agentDto->image]);
        }

        return $agent;
    }

    private function denormalizeDto(array $data): AgentDto
    {
        return $this->serializer->denormalize($data, AgentDto::class, context: [
            AbstractNormalizer::CALLBACKS => [
                'image' => function () use ($data): ?File {
                    if (false === isset($data['image'])) {
                        return null;
                    }

                    return $this->fileService->uploadImage($this->parameterBag->get('app.dir.agent.profile'), $data['image']);
                },
            ],
        ]);
    }

    private function organizeDefaultAgentData(array $user): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => "{$user['firstname']} {$user['lastname']}",
            'shortBio' => 'Agente criado automaticamente',
            'longBio' => 'Este agente foi criado automaticamente pelo sistema',
            'culture' => false,
            'user' => $user['id'],
        ];
    }
}
