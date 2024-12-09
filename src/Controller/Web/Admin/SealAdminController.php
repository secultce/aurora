<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use DateTime;
use Symfony\Component\HttpFoundation\Response;

class SealAdminController extends AbstractAdminController
{
    public function list(): Response
    {
        $seals = [
            ['name' => 'Selo Um', 'status' => 'Ativo', 'createdAt' => new DateTime('2023-12-01 10:00:00')],
            ['name' => 'Selo Dois', 'status' => 'Inativo', 'createdAt' => new DateTime('2023-11-25 15:30:00')],
        ];

        return $this->render('seal/list.html.twig', [
            'seals' => $seals,
        ]);
    }

    public function getOne(int $id): Response
    {
        $seal = [
            'name' => 'Selo '.$id,
            'status' => 'Ativo',
            'createdAt' => new DateTime('2023-12-01 10:00:00'),
        ];

        return $this->render('seal/one.html.twig', [
            'seal' => $seal,
        ]);
    }
}
