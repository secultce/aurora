<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Controller\Web\AbstractWebController;
use App\Enum\FlashMessageTypeEnum;
use App\Exception\ValidatorException;
use App\Service\Interface\ArchitecturalAccessibilityServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ArchitecturalAccessibilityAdminController extends AbstractWebController
{
    public const VIEW_LIST = '_admin/architectural-accessibility/list.html.twig';
    public const VIEW_ADD = '_admin/architectural-accessibility/create.html.twig';
    public const VIEW_EDIT = '_admin/architectural-accessibility/edit.html.twig';

    public const CREATE_FORM_ID = 'add-architectural-accessibility';
    public const EDIT_FORM_ID = 'edit-architectural-accessibility';

    public function __construct(
        private ArchitecturalAccessibilityServiceInterface $architecturalAccessibilityService,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function list(): Response
    {
        $accessibilities = $this->architecturalAccessibilityService->list();

        return $this->render(self::VIEW_LIST, [
            'accessibilities' => $accessibilities,
        ]);
    }

    public function add(Request $request): Response
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            return $this->render(self::VIEW_ADD, [
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        $this->validCsrfToken(self::CREATE_FORM_ID, $request);

        $errors = [];

        try {
            $this->architecturalAccessibilityService->create([
                'id' => Uuid::v4(),
                'name' => $request->get('name'),
            ]);

            $this->addFlash(
                FlashMessageTypeEnum::SUCCESS->value,
                $this->translator->trans('view.architectural_accessibility.message.created')
            );
        } catch (ValidatorException $exception) {
            $errors = $exception->getConstraintViolationList();
        } catch (Exception $exception) {
            $errors = [$exception->getMessage()];
        }

        if (!empty($errors)) {
            return $this->render(self::VIEW_ADD, [
                'errors' => $errors,
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        return $this->redirectToRoute('admin_architectural_accessibility_list');
    }

    public function edit(string $id, Request $request, ValidatorInterface $validator): Response
    {
        try {
            $accessibility = $this->architecturalAccessibilityService->getOne(Uuid::fromString($id));
        } catch (Exception $exception) {
            $this->addFlash(FlashMessageTypeEnum::ERROR->value, $exception->getMessage());

            return $this->redirectToRoute('admin_architectural_accessibility_list');
        }

        if (!$request->isMethod(Request::METHOD_POST)) {
            return $this->render(self::VIEW_EDIT, [
                'accessibility' => $accessibility,
                'form_id' => self::EDIT_FORM_ID,
            ]);
        }

        $this->validCsrfToken(self::EDIT_FORM_ID, $request);

        try {
            $this->architecturalAccessibilityService->update(Uuid::fromString($id), [
                'name' => $request->get('name'),
            ]);

            $this->addFlash(
                FlashMessageTypeEnum::SUCCESS->value,
                $this->translator->trans('view.architectural_accessibility.message.updated')
            );

            return $this->redirectToRoute('admin_architectural_accessibility_list');
        } catch (ValidatorException $exception) {
            return $this->render(self::VIEW_EDIT, [
                'accessibility' => $accessibility,
                'errors' => $exception->getConstraintViolationList(),
                'form_id' => self::EDIT_FORM_ID,
            ]);
        }
    }

    public function remove(string $id): Response
    {
        try {
            $this->architecturalAccessibilityService->remove(Uuid::fromString($id));

            $this->addFlash(
                FlashMessageTypeEnum::SUCCESS->value,
                $this->translator->trans('view.architectural_accessibility.message.deleted')
            );
        } catch (Exception $exception) {
            $this->addFlash(FlashMessageTypeEnum::ERROR->value, $exception->getMessage());
        }

        return $this->redirectToRoute('admin_architectural_accessibility_list');
    }
}
