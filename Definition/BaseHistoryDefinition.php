<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Definition;

class BaseHistoryDefinition implements HistoryDefinitionInterface
{
    private ?string $mainClass;

    public function __construct(string $mainClass = null)
    {
        $this->mainClass = $mainClass;
    }

    public function getMainClass(): string
    {
        return $this->mainClass ?: 'SomeNonExistingEntity';
    }

    public function getAssociatedClasses(): array
    {
        return [];
    }

    public function getChildDefinitions(): array
    {
        return [];
    }
}
