<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use whatwedo\CrudBundle\Definition\DefinitionInterface;
use whatwedo\CrudBundle\Manager\DefinitionManager;
use whatwedo\CrudHistoryBundle\Definition\BaseHistoryDefinition;
use whatwedo\CrudHistoryBundle\Definition\HasHistoryDefinition;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudHistoryBundle\Tests\App\Definition\History\CompanyHistoryDefinition;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\CompanyFactory;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\PersonFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DefinitionTest extends KernelTestCase
{
    use Factories;
    use ResetDatabase;

    public function testHistoryDefinition()
    {
        $entity = CompanyFactory::createOne()->object();

        $definitionManager = self::getContainer()->get(DefinitionManager::class);
        $definition = $definitionManager->getDefinitionByEntity($entity);

        $this->assertInstanceOf(DefinitionInterface::class, $definition);
        $this->assertInstanceOf(HasHistoryDefinition::class, $definition);
    }

    public function testGetHistoryDefintion()
    {
        $entity = CompanyFactory::createOne()->object();

        $historyManager = self::getContainer()->get(HistoryManager::class);
        $definition = $historyManager->getHistoryDefinition($entity);

        $this->assertInstanceOf(CompanyHistoryDefinition::class, $definition);
    }

    public function testGetBaseDefinition()
    {
        $entity = PersonFactory::createOne()->object();

        $historyManager = self::getContainer()->get(HistoryManager::class);
        $definition = $historyManager->getHistoryDefinition($entity);

        $this->assertInstanceOf(BaseHistoryDefinition::class, $definition);
    }
}
