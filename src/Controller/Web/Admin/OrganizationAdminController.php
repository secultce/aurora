<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\DocumentService\OrganizationTimelineDocumentService;
use App\Exception\ValidatorException;
use App\Service\Interface\OrganizationServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrganizationAdminController extends AbstractAdminController
{
    public const VIEW_ADD = 'organization/add.html.twig';
    public const VIEW_TIMELINE = 'organization/timeline.html.twig';

    public function __construct(
        private OrganizationServiceInterface $service,
        private readonly TranslatorInterface $translator,
        private readonly OrganizationTimelineDocumentService $documentService,
    ) {
    }

    public function list(): Response
    {
        $organizations = $this->service->findBy();

        return $this->render('organization/list.html.twig', [
            'organizations' => $organizations,
        ]);
    }

    public function add(Request $request, ValidatorInterface $validator): Response
    {
        if ('POST' !== $request->getMethod()) {
            return $this->render(self::VIEW_ADD);
        }

        try {
            $this->service->create([
                'id' => Uuid::v4(),
                'name' => $request->get('name'),
            ]);
        } catch (ValidatorException $exception) {
            return $this->render(self::VIEW_ADD, [
                'errors' => $exception->getConstraintViolationList(),
            ]);
        } catch (Exception $exception) {
            return $this->render(self::VIEW_ADD, [
                'errors' => [
                    $exception->getMessage(),
                ],
            ]);
        }

        $this->addFlash('success', $this->translator->trans('view.organization.message.created'));

        return $this->redirectToRoute('admin_organization_list');
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', $this->translator->trans('view.organization.message.deleted'));

        return $this->redirectToRoute('admin_organization_list');
    }

    public function timeline(Uuid $id): Response
    {
        $events = $this->documentService->getEventsByEntityId($id);

        return $this->render(self::VIEW_TIMELINE, [
            'organization' => $this->service->get($id),
            'events' => $events,
        ]);
    }
}
