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

class FaqAdminController extends AbstractWebController
{
    public const VIEW_ADD = '_admin/faq/add.html.twig';

    public function __construct(
        private FaqServiceInterface $faqService
    ) {
    }

    public function add(Request $request, ValidatorInterface $validator): Response
    {
        if (false === $request->isMethod('POST')) {
            return $this->render(self::VIEW_ADD);
        }

        try {
            $this->faqService->create([
                'id' => Uuid::v4(),
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

        return $this->redirectToRoute('admin_dashboard');
    }

    public function list(): Response
    {
        $faqs = $this->faqService->list();

        return $this->render('_admin/faq/list.html.twig', [
            'faqs' => $faqs,
        ]);
    }
}
