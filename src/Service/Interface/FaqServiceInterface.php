<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Faq;
use Symfony\Component\Uid\Uuid;

interface FaqServiceInterface
{
    public function create(array $faq): Faq;

    public function update(Uuid $identifier, array $faq): Faq;
}
