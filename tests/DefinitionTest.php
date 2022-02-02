<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use whatwedo\CrudBundle\Definition\DefinitionInterface;
use whatwedo\CrudBundle\Manager\DefinitionManager;
use whatwedo\CrudHistoryBundle\CrudDefintion\HistoryInterface;
use whatwedo\CrudHistoryBundle\Definition\BaseHistoryDefinition;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudHistoryBundle\Tests\App\Definition\History\CompanyHistoryDefinition;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\CompanyFactory;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\PersonFactory;
use whatwedo\CrudHistoryBundle\Tests\App\Helper\ResetDatabase;
use Zenstruck\Foundry\Test\Factories;

class DefinitionTest extends KernelTestCase
{
    use Factories;
    use ResetDatabase;

    public function testHistoryDefinition()
    {
        $this->_resetDatabase();

        $entity = CompanyFactory::createOne()->object();

        $definitionManager = self::getContainer()->get(DefinitionManager::class);
        $definition = $definitionManager->getDefinitionByEntity($entity);

        $this->assertInstanceOf(DefinitionInterface::class, $definition);
        $this->assertInstanceOf(HistoryInterface::class, $definition);
    }

    public function testGetHistoryDefintion()
    {
        $this->_resetDatabase();
        $entity = CompanyFactory::createOne()->object();

        $historyManager = self::getContainer()->get(HistoryManager::class);
        $definition = $historyManager->getHistoryDefinition($entity);

        $this->assertInstanceOf(CompanyHistoryDefinition::class, $definition);
    }

    public function testGetBaseDefinition()
    {
        $this->_resetDatabase();
        $entity = PersonFactory::createOne()->object();

        $historyManager = self::getContainer()->get(HistoryManager::class);
        $definition = $historyManager->getHistoryDefinition($entity);

        $this->assertInstanceOf(BaseHistoryDefinition::class, $definition);
    }
}
