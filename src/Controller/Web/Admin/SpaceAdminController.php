<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\SpaceServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class SpaceAdminController extends AbstractAdminController
{
    public function __construct(
        private SpaceServiceInterface $service,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function list(): Response
    {
        $spaces = $this->service->findBy();

        return $this->render('space/list.html.twig', [
            'spaces' => $spaces,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', $this->translator->trans('view.space.message.deleted'));

        return $this->redirectToRoute('admin_space_list');
    }
}
