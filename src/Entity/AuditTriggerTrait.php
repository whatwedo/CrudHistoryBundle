<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait AuditTriggerTrait
{
    /**
     * @ORM\Column(type="integer")
     */
    private int $auditTrigger = 0;

    public function triggerAudit()
    {
        ++$this->auditTrigger;
    }
}
