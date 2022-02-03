<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\CompanyFactory;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\ContactFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class HistoryTest extends KernelTestCase
{
    use Factories;
    use ResetDatabase;

    public function testCompanyHistory()
    {
        $entity = CompanyFactory::createOne()->object();
        $historyManager = self::getContainer()->get(HistoryManager::class);

        $entityHistory = $historyManager->getHistory($entity);

        $this->assertIsArray($entityHistory);
        $this->assertCount(1, $entityHistory);
    }

    public function testCompanyContactHistory()
    {
        $company = CompanyFactory::createOne([
            'name' => 'whatwedo GmbH',
            'city' => 'Bern',
            'country' => 'Switzerland',
            'taxIdentificationNumber' => '123456789',
        ])->object();

        ContactFactory::createOne([
            'name' => 'Mauri',
            'company' => $company,
        ]);

        $historyManager = self::getContainer()->get(HistoryManager::class);

        $entityHistory = $historyManager->getHistory($company);

        $this->assertIsArray($entityHistory);
        $this->assertCount(2, $entityHistory);

        // last is the contact change....

        $this->assertCount(1, $entityHistory[array_keys($entityHistory)[0]]);
        $this->assertSame([
            'company' => [
                'new' => [
                    'class' => 'whatwedo\CrudHistoryBundle\Tests\App\Entity\Company',
                    'id' => 1,
                    'label' => 'whatwedo\CrudHistoryBundle\Tests\App\Entity\Company#1',
                    'table' => 'company',
                ],
                'old' => null,
            ],
            'name' => [
                'new' => 'Mauri',
                'old' => null,
            ],
        ], $entityHistory[array_keys($entityHistory)[0]][0]->getEntry()->getDiffs());

        // company insert

        $this->assertCount(1, $entityHistory[array_keys($entityHistory)[1]]);
        $this->assertSame([
            'city' => [
                'new' => 'Bern',
                'old' => null,
            ],
            'country' => [
                'new' => 'Switzerland',
                'old' => null,
            ],
            'name' => [
                'new' => 'whatwedo GmbH',
                'old' => null,
            ],
            'taxIdentificationNumber' => [
                'new' => '123456789',
                'old' => null,
            ],
        ], $entityHistory[array_keys($entityHistory)[1]][0]->getEntry()->getDiffs());
    }
}
