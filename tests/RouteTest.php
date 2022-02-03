<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\RouterInterface;

class RouteTest extends KernelTestCase
{
    public function testRoute()
    {
        /** @var RouterInterface $router */
        $router = self::getContainer()->get(RouterInterface::class);

        $this->assertSame(
            '/whatwedo_crud_history_tests_app_company/1/history',
            $router->generate('whatwedo_crud_history_tests_app_company_history', [
                'id' => 1,
            ])
        );
    }
}
