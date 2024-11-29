<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\Faq;

interface FaqRepositoryInterface
{
    public function save(Faq $faq): Faq;
}
