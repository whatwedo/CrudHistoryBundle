<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Definition;

interface HasHistoryDefinition
{
    public function getHistoryDefinition(): string;
}
