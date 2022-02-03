<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Entity;

interface AuditManyToOneTriggerInterface
{
    public function triggerManyToOne();
}
