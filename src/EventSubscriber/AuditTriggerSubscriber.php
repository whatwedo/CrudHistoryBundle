<?php

declare(strict_types=1);
/*
 * Copyright (c) 2020, whatwedo GmbH
 * All rights reserved
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 * NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace whatwedo\CrudHistoryBundle\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use whatwedo\CrudHistoryBundle\Entity\AuditManyToOneTriggerInterface;

final class AuditTriggerSubscriber implements EventSubscriberInterface
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::onFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $args): void
    {
        $entityManager = $args->getObjectManager();
        $unitOfWork = $entityManager->getUnitOfWork();

        $updatedEntities = $unitOfWork->getScheduledEntityUpdates();
        $insertedEntities = $unitOfWork->getScheduledEntityInsertions();

        if (count($updatedEntities) > 0 || count($insertedEntities) > 0) {
            $this->handleEntities($insertedEntities, $entityManager);
            $this->handleEntities($updatedEntities, $entityManager);
        }
    }

    /**
     * @param object[] $entities
     */
    private function handleEntities(array $entities, EntityManagerInterface $entityManager): void
    {
        foreach ($entities as $entity) {
            if ($entity instanceof AuditManyToOneTriggerInterface) {
                $touchedEntities = $entity->triggerManyToOne();

                foreach ($touchedEntities as $touchedEntity) {
                    if ($touchedEntity === null) {
                        continue;
                    }
                    $entityManager->getUnitOfWork()->recomputeSingleEntityChangeSet($entityManager->getClassMetadata(get_class($touchedEntity)), $touchedEntity);
                }
            }
        }
    }
}
