<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\ActivityArea;

interface ActivityAreaRepositoryInterface
{
    public function save(ActivityArea $activityArea): ActivityArea;
}
