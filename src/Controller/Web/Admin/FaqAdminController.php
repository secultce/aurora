<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Controller\Web\AbstractWebController;
use App\Enum\FlashMessageTypeEnum;
use App\Exception\ValidatorException;
use App\Service\Interface\FaqServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class FaqAdminController extends AbstractWebController
{
    public const VIEW_LIST = '_admin/faq/list.html.twig';
    public const VIEW_ADD = '_admin/faq/add.html.twig';
    public const VIEW_EDIT = '_admin/faq/edit.html.twig';

    public function __construct(
        private FaqServiceInterface $faqService,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function add(Request $request): Response
    {
        if (false === $request->isMethod(Request::METHOD_POST)) {
            return $this->render(self::VIEW_ADD);
        }

        $errors = [];

        try {
            $this->faqService->create([
                'id' => Uuid::v4(),
                'answer' => $request->get('answer'),
                'question' => $request->get('question'),
            ]);

            $this->addFlash(FlashMessageTypeEnum::SUCCESS->value, $this->translator->trans('view.faq.message.created'));
        } catch (ValidatorException $exception) {
            $errors = $exception->getConstraintViolationList();
        } catch (Exception $exception) {
            $errors = [$exception->getMessage()];
        }

        if (false === empty($errors)) {
            return $this->render(self::VIEW_ADD, ['errors' => $errors]);
        }

        return $this->redirectToRoute('admin_faq_list');
    }

    public function list(): Response
    {
        $faqs = $this->faqService->list();

        return $this->render(self::VIEW_LIST, [
            'faqs' => $faqs,
        ]);
    }

    public function remove(string $id): Response
    {
        try {
            $this->faqService->remove(Uuid::fromString($id));
            $this->addFlash(FlashMessageTypeEnum::SUCCESS->value, $this->translator->trans('view.faq.message.deleted'));
        } catch (Exception $exception) {
            $this->addFlash(FlashMessageTypeEnum::ERROR->value, $exception->getMessage());
        }

        return $this->redirectToRoute('admin_faq_list');
    }

    public function edit(string $id, Request $request, ValidatorInterface $validator): Response
    {
        try {
            $faq = $this->faqService->get(Uuid::fromString($id));
        } catch (Exception $exception) {
            $this->addFlash(FlashMessageTypeEnum::ERROR->value, $exception->getMessage());

            return $this->redirectToRoute('admin_faq_list');
        }

        if (false === $request->isMethod(Request::METHOD_POST)) {
            return $this->render(self::VIEW_EDIT, [
                'faq' => $faq,
            ]);
        }

        try {
            $this->faqService->update(Uuid::fromString($id), [
                'question' => $request->get('question'),
                'answer' => $request->get('answer'),
            ]);

            $this->addFlash(FlashMessageTypeEnum::SUCCESS->value, $this->translator->trans('view.faq.message.updated'));

            return $this->redirectToRoute('admin_faq_list');
        } catch (ValidatorException $exception) {
            return $this->render(self::VIEW_EDIT, [
                'faq' => $faq,
                'errors' => $exception->getConstraintViolationList(),
            ]);
        }
    }
}
