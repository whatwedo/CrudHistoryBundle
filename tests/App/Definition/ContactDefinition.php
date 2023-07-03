<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests\App\Definition;

use araise\CrudBundle\Builder\DefinitionBuilder;
use araise\CrudBundle\Definition\AbstractDefinition;
use araise\TableBundle\Table\Table;
use whatwedo\CrudHistoryBundle\Tests\App\Entity\Contact;

class ContactDefinition extends AbstractDefinition
{
    public static function getEntity(): string
    {
        return Contact::class;
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
}
