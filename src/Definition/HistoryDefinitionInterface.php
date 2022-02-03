<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Definition;

interface HistoryDefinitionInterface
{
    public function getMainClass(): string;

    public function getChildDefinitions(): array;

    /**
     * @return HistoryAssociatedClass[]
     */
    public function getAssociatedClasses(): array;
}
