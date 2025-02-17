<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractWebController extends AbstractController
{
    public function getOrderParam(array $filters): array
    {
        $order = 'DESC';

        if (isset($filters['order']) && in_array($filters['order'], ['ASC', 'DESC'])) {
            $order = $filters['order'];
        }

        unset($filters['order']);

        return ['order' => $order, 'filters' => $filters];
    }
}
