<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\CompanyFactory;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\ContactFactory;
use whatwedo\CrudHistoryBundle\Tests\App\Helper\ResetDatabase;
use Zenstruck\Foundry\Test\Factories;

class HistoryTest extends KernelTestCase
{
    use Factories;
    use ResetDatabase;

    public function testCompanyHistory()
    {
        $this->_resetDatabase();
        $entity = CompanyFactory::createOne()->object();
        $historyManager = self::getContainer()->get(HistoryManager::class);

        $entityHistory = $historyManager->getHistory($entity);

        $this->assertIsArray($entityHistory);
        $this->assertCount(1, $entityHistory);
    }

    public function testCompanyContactHistory()
    {
        $this->_resetDatabase();
        $company = CompanyFactory::createOne()->object();

        $contact = ContactFactory::createOne(['company' => $company]);


        $historyManager = self::getContainer()->get(HistoryManager::class);

        $entityHistory = $historyManager->getHistory($company);

        $this->assertIsArray($entityHistory);
        $this->assertCount(1, $entityHistory);
    }
}
