<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests\App\Definition;

use whatwedo\CrudBundle\Builder\DefinitionBuilder;
use whatwedo\CrudBundle\Definition\AbstractDefinition;
use whatwedo\CrudHistoryBundle\Tests\App\Entity\Contact;
use whatwedo\TableBundle\Table\Table;

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
