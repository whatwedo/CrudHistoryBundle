<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Definition;

class HistoryAssociatedClass
{
    public string $entityFqcn;

    public array $filter = [];

    public function __construct(string $entityFqcn, array $filter)
    {
        $this->entityFqcn = $entityFqcn;
        $this->filter = $filter;
    }
}
