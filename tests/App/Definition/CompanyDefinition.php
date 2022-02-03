<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests\App\Definition;

use whatwedo\CrudBundle\Builder\DefinitionBuilder;
use whatwedo\CrudBundle\Definition\AbstractDefinition;
use whatwedo\CrudHistoryBundle\Definition\HasHistoryDefinition;
use whatwedo\CrudHistoryBundle\Page\HistoryPage;
use whatwedo\CrudHistoryBundle\Tests\App\Definition\History\CompanyHistoryDefinition;
use whatwedo\CrudHistoryBundle\Tests\App\Entity\Company;
use whatwedo\TableBundle\Table\Table;

class CompanyDefinition extends AbstractDefinition implements HasHistoryDefinition
{
    public static function getEntity(): string
    {
        return Company::class;
    }

    public static function getCapabilities(): array
    {
        return array_merge(
            [HistoryPage::HISTORY],
            parent::getCapabilities()
        );
    }

    public function configureView(DefinitionBuilder $builder, $data): void
    {
        parent::configureView($builder, $data);

        $builder
            ->addBlock('base')
            ->addContent('name')
        ;
    }

    public function configureTable(Table $table): void
    {
        parent::configureTable($table);
        $table
            ->addColumn('name')
        ;
    }

    public function getHistoryDefinition(): string
    {
        return CompanyHistoryDefinition::class;
    }
}
