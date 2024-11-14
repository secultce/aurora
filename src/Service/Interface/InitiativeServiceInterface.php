<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Initiative;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationList;

interface InitiativeServiceInterface
{
    public function findBy(array $params = []): array;

    public function findOneBy(array $params): ?Initiative;

    public function get(Uuid $id): Initiative;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;

    public function create(array $initiative): Initiative|ConstraintViolationList;

    public function update(Uuid $id, array $initiative): Initiative;

    public function count(): int;
}
