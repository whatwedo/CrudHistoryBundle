<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Page;

use whatwedo\CrudBundle\Enums\PageInterface;

enum HistoryPage: string implements PageInterface
{
    public function toRoute(): string
    {
        return strtolower($this->name);
    }
    case HISTORY = 'history';
}
