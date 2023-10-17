<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Entity;

interface AuditManyToOneTriggerInterface
{
    /**
     * Can be used to trigger related entity objects
     *
     * @return array holds all triggered objects. Will be used to save the audit increment. You can write null values to this array, this allows you to use getters very easily.
     */
    public function triggerManyToOne(): array;
}
