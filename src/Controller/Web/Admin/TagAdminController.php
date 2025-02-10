<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\TagService;
use Symfony\Component\HttpFoundation\Response;

class TagAdminController extends AbstractAdminController
{
    public function __construct(
        private readonly TagService $tagService,
    ) {
    }

    public function list(): Response
    {
        return $this->render('/tag/list.html.twig', [
            'tags' => $this->tagService->list(),
        ]);
    }
}
