<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Definition;

interface HistoryDefinitionInterface
{
    public function getMainClass(): string;

    public function getChildDefinitions(): array;

    /**
     * @return HistoryAsscoiatedClass[]
     */
    public function getAssociatedClasses(): array;
}
