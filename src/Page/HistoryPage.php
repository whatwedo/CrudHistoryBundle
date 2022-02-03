<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Page;

use whatwedo\CrudBundle\Enum\PageInterface;

enum HistoryPage: string implements PageInterface
{
    case HISTORY = 'history';

    public function toRoute(): string
    {
        return strtolower($this->name);
    }
}
