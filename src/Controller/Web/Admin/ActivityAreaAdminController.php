<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Controller\Web\AbstractWebController;
use App\Enum\FlashMessageTypeEnum;
use App\Exception\ValidatorException;
use App\Service\Interface\ActivityAreaServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ActivityAreaAdminController extends AbstractWebController
{
    public const VIEW_LIST = '_admin/activity-area/list.html.twig';
    public const VIEW_ADD = '_admin/activity-area/create.html.twig';
    public const VIEW_EDIT = '_admin/activity-area/edit.html.twig';

    public function __construct(
        private ActivityAreaServiceInterface $activityAreaService,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function add(Request $request): Response
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            return $this->render(self::VIEW_ADD);
        }

        $errors = [];

        try {
            $this->activityAreaService->create([
                'id' => Uuid::v4(),
                'name' => $request->get('name'),
            ]);

            $this->addFlash(
                FlashMessageTypeEnum::SUCCESS->value,
                $this->translator->trans('activity_created')
            );
        } catch (ValidatorException $exception) {
            $errors = $exception->getConstraintViolationList();
        } catch (Exception $exception) {
            $errors = [$exception->getMessage()];
        }

        if (!empty($errors)) {
            return $this->render(self::VIEW_ADD, ['errors' => $errors]);
        }

        return $this->redirectToRoute('admin_activity_area_list');
    }

    public function list(): Response
    {
        $activityAreas = $this->activityAreaService->list();

        return $this->render(self::VIEW_LIST, [
            'activity_areas' => $activityAreas,
        ]);
    }

    public function remove(string $id): Response
    {
        try {
            $this->activityAreaService->remove(Uuid::fromString($id));
            $this->addFlash(
                FlashMessageTypeEnum::SUCCESS->value,
                $this->translator->trans('activity_deleted')
            );
        } catch (Exception $exception) {
            $this->addFlash(FlashMessageTypeEnum::ERROR->value, $exception->getMessage());
        }

        return $this->redirectToRoute('admin_activity_area_list');
    }

    public function edit(string $id, Request $request, ValidatorInterface $validator): Response
    {
        try {
            $activityArea = $this->activityAreaService->get(Uuid::fromString($id));
        } catch (Exception $exception) {
            $this->addFlash(FlashMessageTypeEnum::ERROR->value, $exception->getMessage());

            return $this->redirectToRoute('admin_activity_area_list');
        }

        if (!$request->isMethod(Request::METHOD_POST)) {
            return $this->render(self::VIEW_EDIT, [
                'activity_area' => $activityArea,
            ]);
        }

        try {
            $this->activityAreaService->update(Uuid::fromString($id), [
                'name' => $request->get('name'),
            ]);

            $this->addFlash(
                FlashMessageTypeEnum::SUCCESS->value,
                $this->translator->trans('activity_updated')
            );

            return $this->redirectToRoute('admin_activity_area_list');
        } catch (ValidatorException $exception) {
            return $this->render(self::VIEW_EDIT, [
                'activity_area' => $activityArea,
                'errors' => $exception->getConstraintViolationList(),
            ]);
        }
    }
}
