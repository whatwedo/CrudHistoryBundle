<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\EventSubscriber;

use araise\CrudBundle\Event\CrudEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use whatwedo\CrudHistoryBundle\Entity\AuditManyToOneTriggerInterface;

class AuditSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CrudEvent::PRE_EDIT_PREFIX => [
                ['triggerManyToOneAssciations', 10], ],
            CrudEvent::PRE_DELETE_PREFIX => [
                ['triggerManyToOneAssciations', 10], ],
        ];
    }

    public function triggerManyToOneAssciations(CrudEvent $event)
    {
        if ($event->getEntity() instanceof AuditManyToOneTriggerInterface) {
            $event->getEntity()->triggerManyToOne();
        }
    }
}
