<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Web;

use App\Controller\Web\AbstractWebController;
use App\Tests\AbstractWebTestCase;

class AbstractWebControllerTest extends AbstractWebTestCase
{
    private AbstractWebController $controller;

    protected function setUp(): void
    {
        $this->controller = new class extends AbstractWebController {
        };
    }

    public function testGetOrderParamDefault(): void
    {
        $filters = ['name' => 'Talyson'];
        $result = $this->controller->getOrderParam($filters);

        $this->assertArrayHasKey('order', $result);
        $this->assertEquals('DESC', $result['order']);

        $this->assertArrayHasKey('filters', $result);
        $this->assertEquals($filters, $result['filters']);
    }

    public function testGetOrderParamWithASCOrder(): void
    {
        $filters = ['order' => 'ASC', 'name' => 'Talyson'];
        $result = $this->controller->getOrderParam($filters);

        $this->assertEquals('ASC', $result['order']);
        $expectedFilters = ['name' => 'Talyson'];
        $this->assertEquals($expectedFilters, $result['filters']);
    }

    public function testGetOrderParamWithDESCOrder(): void
    {
        $filters = ['order' => 'DESC', 'name' => 'Talyson'];
        $result = $this->controller->getOrderParam($filters);

        $this->assertEquals('DESC', $result['order']);
        $expectedFilters = ['name' => 'Talyson'];
        $this->assertEquals($expectedFilters, $result['filters']);
    }

    public function testGetOrderParamWithInvalidOrder(): void
    {
        $filters = ['order' => 'INVALID', 'name' => 'Talyson'];
        $result = $this->controller->getOrderParam($filters);

        $this->assertEquals('DESC', $result['order']);
        $expectedFilters = ['name' => 'Talyson'];
        $this->assertEquals($expectedFilters, $result['filters']);
    }
}
