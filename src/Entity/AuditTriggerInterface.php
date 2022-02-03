<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Entity;

interface AuditTriggerInterface
{
    public const FIELD_NAME = 'auditTrigger';

    public function triggerAudit();
}
