<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\SpaceTypeServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class SpaceTypeAdminController extends AbstractAdminController
{
    private const string LIST = 'space-type/list.html.twig';

    public function __construct(
        private readonly SpaceTypeServiceInterface $service,
    ) {
    }

    public function list(): Response
    {
        $spaceTypes = $this->service->list();

        return $this->render(self::LIST, [
            'spaceTypes' => $spaceTypes,
        ]);
    }
}
