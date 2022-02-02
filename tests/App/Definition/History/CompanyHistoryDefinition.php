<?php

declare(strict_types=1);

namespace App\Definition\History;

use whatwedo\CrudHistoryBundle\Definition\HistoryAsscoiatedClass;
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
     * @return HistoryAsscoiatedClass[]
     */
    public function getAssociatedClasses(): array
    {
        return [
            new HistoryAsscoiatedClass(Contact::class, []),
        ];
    }

    public function getChildDefinitions(): array
    {
        return [];
    }
}
