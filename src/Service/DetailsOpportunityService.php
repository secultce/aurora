<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Interface\DetailsOpportunityServiceInterface;

class DetailsOpportunityService implements DetailsOpportunityServiceInterface
{
    public function findDetailsById(string $id): ?array
    {
        $data = [
            'id' => 'default-id',
            'name' => 'Edital para Seleção de Artistas de Rua - Circuito Cultural Nordestino',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.',
            'image_url' => '/images/opportunity-icon.png',
        ];

        return $id === 'default-id' ? $data : null;
    }
}
