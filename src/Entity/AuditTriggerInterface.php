<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Entity;

interface AuditTriggerInterface
{
    public function increaseAuditCounter();
}
