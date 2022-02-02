<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\CompanyFactory;
use whatwedo\CrudHistoryBundle\Tests\App\Helper\ResetDatabase;
use Zenstruck\Foundry\Test\Factories;

class HistoryTest extends KernelTestCase
{
    use Factories;
    use ResetDatabase;

    public function testGetHistoryDefintion()
    {
        $this->_resetDatabase();
        $entity = CompanyFactory::createOne()->object();

        $historyManager = self::getContainer()->get(HistoryManager::class);

        $entityHistory = $historyManager->getHistory($entity);

        $this->assertIsArray($entityHistory);
    }
}
