<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\CrudDefinition;

interface HistoryInterface
{
    public function getHistoryDefinition(): string;
}
