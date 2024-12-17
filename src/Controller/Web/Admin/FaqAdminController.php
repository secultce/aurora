<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Controller\Web\AbstractWebController;
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
    public const VIEW_ADD = '_admin/faq/add.html.twig';
    public const VIEW_EDIT = '_admin/faq/edit.html.twig';

    public function __construct(
        private FaqServiceInterface $faqService,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function add(Request $request, ValidatorInterface $validator): Response
    {
        if (false === $request->isMethod('POST')) {
            return $this->render(self::VIEW_ADD);
        }

        try {
            $this->faqService->create([
                'answer' => $request->get('answer'),
                'question' => $request->get('question'),
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

        return $this->redirectToRoute('admin_faq_list');
    }

    public function list(): Response
    {
        $faqs = $this->faqService->list();

        return $this->render('_admin/faq/list.html.twig', [
            'faqs' => $faqs,
        ]);
    }

    public function remove(string $id): Response
    {
        try {
            $this->faqService->remove(Uuid::fromString($id));
            $this->addFlash('success', 'FAQ removida com sucesso.');
        } catch (Exception $e) {
            $this->addFlash('error', 'Erro ao remover a FAQ.');
        }

        return $this->redirectToRoute('admin_faq_list');
    }

    public function edit(string $id, Request $request, ValidatorInterface $validator): Response
    {
        try {
            $faq = $this->faqService->get(Uuid::fromString($id));
        } catch (Exception $e) {
            throw $this->createNotFoundException('FAQ não encontrada.');
        }

        if (!$request->isMethod('POST')) {
            return $this->render(self::VIEW_EDIT, [
                'faq' => $faq,
            ]);
        }

        try {
            $this->faqService->update(Uuid::fromString($id), [
                'question' => $request->get('question'),
                'answer' => $request->get('answer'),
            ]);

            $this->addFlash('success', 'FAQ atualizada com sucesso.');

            return $this->redirectToRoute('admin_faq_list');
        } catch (ValidatorException $exception) {
            return $this->render(self::VIEW_EDIT, [
                'faq' => $faq,
                'errors' => $exception->getConstraintViolationList(),
            ]);
        }
    }
}
