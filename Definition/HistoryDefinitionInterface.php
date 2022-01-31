<?php

declare(strict_types=1);

namespace whatwedo\AuditorCrudExtensionBundle\Definition;

interface HistoryDefinitionInterface
{
    public const TAG = 'app.history_definition';

    public function getMainClass(): string;

    public function getChildDefinitions(): array;

    /**
     * @return HistoryAsscoiatedClass[]
     */
    public function getAssociatedClasses(): array;
}
