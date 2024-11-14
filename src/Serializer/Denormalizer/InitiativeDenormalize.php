<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Agent;
use App\Entity\Initiative;
use App\Entity\Space;
use App\Service\Interface\FileServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class InitiativeDenormalize implements DenormalizerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Autowire(service: 'serializer.normalizer.object')]
        private DenormalizerInterface $denormalizer,
        private readonly FileServiceInterface $fileService,
        private readonly ParameterBagInterface $parameterBag,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (Initiative::class !== $type) {
            return $data;
        }

        if (false === empty($data['extraFields']['coverImage'])) {
            $this->uploadImageExtraFields($data['extraFields'], $context['object_to_populate'] ?? null);
        }

        $initiative = $this->denormalizer->denormalize($data, $type, $format, $context);

        if (isset($data['createdBy'])) {
            $data['createdBy'] = $this->entityManager->getRepository(Agent::class)->find($data['createdBy']);
            $initiative->setCreatedBy($data['createdBy']);
        }

        if (isset($data['parent'])) {
            $data['parent'] = $this->entityManager->getRepository(Initiative::class)->find($data['parent']);
            $initiative->setParent($data['parent']);
        }

        if (isset($data['space'])) {
            $data['space'] = $this->entityManager->getRepository(Space::class)->find($data['space']);
            $initiative->setSpace($data['space']);
        }

        return $initiative;
    }

    private function uploadImageExtraFields(array &$extraFields, ?Initiative $initiativeFromDb = null): void
    {
        if (false === is_null($initiativeFromDb) && true === is_string($initiativeFromDb->getExtraFields()['coverImage'])) {
            $this->fileService->deleteFileByUrl($initiativeFromDb->getExtraFields()['coverImage']);
        }

        $extraFields['coverImage'] = $this->fileService->uploadImage($this->parameterBag->get('app.dir.initiative.cover_image'), $extraFields['coverImage']);

        if ($extraFields['coverImage'] instanceof File) {
            $extraFields['coverImage'] = $this->fileService->getFileUrl($extraFields['coverImage']->getPathname());
        }
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Initiative::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            Initiative::class => true,
        ];
    }
}
