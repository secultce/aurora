<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\User;
use App\Service\Interface\FileServiceInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class UserDenormalizer implements DenormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private DenormalizerInterface $denormalizer,
        private FileServiceInterface $fileService,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (false === is_array($data)) {
            return $this->denormalizer->denormalize(['id' => $data], $type, $format, $context);
        }

        if (User::class !== $type) {
            return $data;
        }

        if (true === array_key_exists('image', $data)) {
            $this->uploadImage($data, $context['object_to_populate'] ?? null);
        }

        /* @var User $user */
        $user = $this->denormalizer->denormalize($data, $type, $format, $context);

        return $user;
    }

    private function uploadImage(array &$data, ?User $userFromDb = null): void
    {
        if (false === is_null($userFromDb) && true === is_string($userFromDb->getImage())) {
            $this->fileService->deleteFileByUrl($userFromDb->getImage());
        }

        if ($data['image'] instanceof File) {
            $data['image'] = $this->fileService->getFileUrl($data['image']->getPathname());
        }
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return User::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            User::class => true,
        ];
    }
}
