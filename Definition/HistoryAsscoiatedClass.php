<?php

declare(strict_types=1);

namespace whatwedo\AuditorCrudExtensionBundle\Definition;

class HistoryAsscoiatedClass
{
    public string $entityFqcn;

    public array $options = [];

    public function __construct(string $entityFqcn, array $options)
    {
        $this->entityFqcn = $entityFqcn;
        $this->options = $options;
    }
}
