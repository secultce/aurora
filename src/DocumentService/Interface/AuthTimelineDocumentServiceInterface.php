<?php

declare(strict_types=1);

namespace App\DocumentService\Interface;

use Symfony\Component\Uid\Uuid;

interface AuthTimelineDocumentServiceInterface
{
    public function getTimelineLoginByUserId(Uuid $userUserId): array;
}
