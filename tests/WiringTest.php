<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudHistoryBundle\Tests\App\Helper\ResetDatabase;
use Zenstruck\Foundry\Test\Factories;

class WiringTest extends KernelTestCase
{
    use Factories;
    use ResetDatabase;

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
