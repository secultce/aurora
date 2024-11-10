<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\City;
use App\Entity\State;
use Symfony\Component\Uid\Uuid;

interface StateServiceInterface
{
    public function findBy(array $params = []): array;

    public function findByCity(City|Uuid $city): ?State;

    public function findOneBy(array $params): ?State;

    public function list(int $limit = 50): array;
}
