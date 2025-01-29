<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Agent;
use App\Entity\Opportunity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

interface OpportunityServiceInterface
{
    public function create(array $opportunity): Opportunity;

    public function get(Uuid $id): Opportunity;

    public function findOneBy(array $params): ?Opportunity;

    public function findBy(array $params = []): array;

    public function list(int $limit = 50): array;

    public function count(?Agent $createdBy = null): int;

    public function remove(Uuid $id): void;

    public function update(Uuid $identifier, array $opportunity): Opportunity;

    public function updateImage(Uuid $id, UploadedFile $uploadedFile): Opportunity;
}
