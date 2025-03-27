<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\CulturalLanguage;
use App\Exception\CulturalLanguage\CulturalLanguageResourceNotFoundException;
use App\Repository\Interface\CulturalLanguageRepositoryInterface;
use App\Service\Interface\CulturalLanguageServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;

readonly class CulturalLanguageService extends AbstractEntityService implements CulturalLanguageServiceInterface
{
    public function __construct(
        private CulturalLanguageRepositoryInterface $repository,
        private Security $security,
    ) {
        parent::__construct($this->security);
    }

    public function get(Uuid $id): CulturalLanguage
    {
        $culturalLanguage = $this->findOneBy(['id' => $id]);

        if (null === $culturalLanguage) {
            throw new CulturalLanguageResourceNotFoundException();
        }

        return $culturalLanguage;
    }

    public function list(int $limit = 50, array $params = []): array
    {
        return $this->repository->findBy(
            $params,
            ['name' => 'ASC'],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $culturalLanguage = $this->findOneBy(['id' => $id]);

        if (null === $culturalLanguage) {
            throw new CulturalLanguageResourceNotFoundException();
        }

        $this->repository->remove($culturalLanguage);
    }

    private function findOneBy(array $array): ?CulturalLanguage
    {
        return $this->repository->findOneBy($array);
    }
}
