<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use Symfony\Component\Uid\Uuid;

class EventActivityTestFixtures
{
    public static function data(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'title' => 'Atividade do evento teste',
            'description' => 'Descrição da atividade do evento teste',
            'startDate' => '2024-07-16T17:22:00+00:00',
            'endDate' => '2024-07-17T17:22:00+00:00',
        ];
    }
}
