<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Service\FaqService;
use Symfony\Component\HttpFoundation\Response;

class FaqWebController extends AbstractWebController
{
    private FaqService $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function faq(): Response
    {
        $faqs = $this->faqService->list();

        return $this->render('faq/faq.html.twig', [
            'faqs' => $faqs,
        ]);
    }
}
