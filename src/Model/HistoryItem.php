<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Model;

use DH\Auditor\Model\Entry;
use Doctrine\Common\Util\ClassUtils;

class HistoryItem
{
    private Entry $entry;

    private string $class;

    private \DateTimeImmutable $date;

    public function __construct(Entry $entry, string $entityFqcn)
    {
        $this->entry = $entry;
        $this->class = ClassUtils::getRealClass($entityFqcn);
        $this->date = is_string($entry->getCreatedAt()) ? new \DateTimeImmutable($entry->getCreatedAt()) : $entry->getCreatedAt();
    }

    public function getEntry(): Entry
    {
        return $this->entry;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}
