<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests\App\Definition\History;

use whatwedo\CrudHistoryBundle\Definition\HistoryAssociatedClass;
use whatwedo\CrudHistoryBundle\Definition\HistoryDefinitionInterface;
use whatwedo\CrudHistoryBundle\Tests\App\Entity\Company;
use whatwedo\CrudHistoryBundle\Tests\App\Entity\Contact;

class CompanyHistoryDefinition implements HistoryDefinitionInterface
{
    public function getMainClass(): string
    {
        return Company::class;
    }

    /**
     * @return HistoryAssociatedClass[]
     */
    public function getAssociatedClasses(): array
    {
        return [
            new HistoryAssociatedClass(Contact::class, []),
        ];
    }

    public function getChildDefinitions(): array
    {
        return [];
    }
}
