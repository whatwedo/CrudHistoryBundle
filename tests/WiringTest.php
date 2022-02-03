<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;

class WiringTest extends KernelTestCase
{
    public function testServiceWiring()
    {
        foreach ([
            HistoryManager::class,
        ] as $serviceClass) {
            $this->assertInstanceOf(
                $serviceClass,
                self::getContainer()->get($serviceClass)
            );
        }
    }
}
