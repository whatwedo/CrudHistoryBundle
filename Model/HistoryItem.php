<?php

declare(strict_types=1);

namespace whatwedo\AuditorCrudExtensionBundle\Model;

use DH\Auditor\Model\Entry;

class HistoryItem
{
    private Entry $entry;

    private string $class;

    private \DateTimeImmutable $date;

    public function __construct(Entry $entry, string $class)
    {
        $this->entry = $entry;
        $this->class = str_replace('Proxies\\__CG__\\', '', $class);
        $this->date = new \DateTimeImmutable($entry->getCreatedAt());
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

    public function getTransalationBaseKey(): string
    {
        return lcfirst(substr(strrchr($this->class, '\\'), 1));
    }
}
