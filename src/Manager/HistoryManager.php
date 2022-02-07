<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Manager;

use DH\Auditor\Model\Entry;
use DH\Auditor\Provider\Doctrine\Persistence\Reader\Filter\SimpleFilter;
use DH\Auditor\Provider\Doctrine\Persistence\Reader\Query;
use DH\Auditor\Provider\Doctrine\Persistence\Reader\Reader;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\PropertyAccess\PropertyAccess;
use whatwedo\CrudBundle\Manager\DefinitionManager;
use whatwedo\CrudHistoryBundle\Definition\BaseHistoryDefinition;
use whatwedo\CrudHistoryBundle\Definition\HasHistoryDefinition;
use whatwedo\CrudHistoryBundle\Definition\HistoryDefinitionInterface;
use whatwedo\CrudHistoryBundle\Entity\AuditTriggerInterface;
use whatwedo\CrudHistoryBundle\Model\HistoryItem;

class HistoryManager
{
    protected Reader $auditReader;

    private DefinitionManager $definitionManager;

    public function __construct(
        Reader $auditReader,
        DefinitionManager $definitionManager
    ) {
        $this->auditReader = $auditReader;
        $this->definitionManager = $definitionManager;
    }

    public function getHistory($entity, int $page = 1): array
    {
        $definition = $this->getHistoryDefinition($entity);

        if (ClassUtils::getClass($entity) !== $definition->getMainClass()) {
            throw new \Exception(ClassUtils::getClass($entity) . ' not suitable for ' . static::class);
        }

        if (! $this->auditReader->getProvider()->isAuditable($entity)) {
            throw $this->createNotFoundException();
        }

        $transActionEntries = [];
        foreach ($definition->getChildDefinitions() as $property) {
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $propertyEntity = $propertyAccessor->getValue($entity, $property);

            if ($propertyEntity) {
                $propertyEntity->getId();
                $childDefinition = $this->getHistoryDefinition($propertyEntity);
                $transActionEntries = array_merge($transActionEntries, $this->getTransActionEntries($childDefinition, $propertyEntity));
            }
        }

        $transActionEntries = array_merge($transActionEntries, $this->getTransActionEntries($definition, $entity));

        return $this->orderTransactions($transActionEntries);
    }

    public function getHistoryDefinition($entity): HistoryDefinitionInterface
    {
        $definition = $this->definitionManager->getDefinitionByEntity($entity);
        if ($definition instanceof HasHistoryDefinition) {
            return new ($definition->getHistoryDefinition())();
        }

        // create a basic Definition
        return new BaseHistoryDefinition(ClassUtils::getClass($entity));
    }

    protected function cleanHistoryItem(Entry $e, $entityFqcn): ?HistoryItem
    {
        if (
            $e->getType() === 'insert'
            || $e->getType() === 'update'
        ) {
            $diffs = $e->getDiffs();

            unset($diffs[AuditTriggerInterface::FIELD_NAME]);
            unset($diffs['id']);

            $reflectionClass = new \ReflectionClass(Entry::class);

            $reflectionProperty = $reflectionClass->getProperty('diffs');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($e, json_encode($diffs));

            if (count($diffs) === 0) {
                return null;
            }
        }

        return new HistoryItem($e, $entityFqcn);
    }

    protected function getItems(Entry $entry, array $transActionEntries, string $entityFqcn, array $filter = []): array
    {
        foreach ($this->auditReader->createQuery($entityFqcn)->addFilter(
            new SimpleFilter(
                Query::TRANSACTION_HASH,
                $entry->getTransactionHash()
            )
        )->execute() as $e) {
            if (in_array($e->getType(), $filter, true)) {
                continue;
            }
            $historyItem = $this->cleanHistoryItem($e, $entityFqcn);
            if ($historyItem) {
                $transActionEntries[$entry->getTransactionHash()][] = $historyItem;
            }
        }

        return $transActionEntries;
    }

    /**
     * @param $entity
     */
    private function getTransActionEntries(HistoryDefinitionInterface $definition, $entity): array
    {
        /** @var array<Entry> $entries */
        $entries = $this->auditReader->createQuery($definition->getMainClass())->addFilter(
            new SimpleFilter(
                Query::OBJECT_ID,
                $entity->getId()
            )
        )->execute();

        $transActions = [];
        $transActionEntries = [];
        foreach ($entries as $entry) {
            if (! isset($transActions[$entry->getTransactionHash()])) {
                $transActions[$entry->getTransactionHash()] = true;
                foreach ($definition->getAssociatedClasses() as $associatedClass) {
                    $transActionEntries = $this->getItems($entry, $transActionEntries, $associatedClass->entityFqcn, $associatedClass->filter);
                }
            }

            $item = $this->cleanHistoryItem($entry, $definition->getMainClass());
            if ($item) {
                $transActionEntries[$entry->getTransactionHash()][] = $item;
            }
            if (count($transActionEntries[$entry->getTransactionHash()]) === 0) {
                unset($transActionEntries[$entry->getTransactionHash()]);
            }
        }

        return $transActionEntries;
    }

    private function orderTransactions(array $transActionEntries): array
    {
        uasort(
            $transActionEntries,
            function (array $a, array $b) {
                /** @var HistoryItem[] $a */
                /** @var HistoryItem[] $b */
                return $b[0]->getDate()->getTimestamp() - $a[0]->getDate()->getTimestamp();
            }
        );

        return $transActionEntries;
    }
}
