<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Faq;
use Symfony\Component\Uid\Uuid;

interface FaqServiceInterface
{
    public function create(array $faq): Faq;

    public function update(Uuid $identifier, array $faq): Faq;

    public function get(Uuid $id): Faq;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;
}
