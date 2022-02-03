<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use whatwedo\CrudBundle\Controller\CrudController;
use whatwedo\CrudBundle\Enum\Page;
use whatwedo\CrudBundle\Manager\DefinitionManager;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;

class HistoryCrudController extends CrudController
{
    public function history(Request $request, HistoryManager $historyManager, DefinitionManager $definitionManager): Response
    {
        $entity = $this->getEntityOr404($request);
        $this->denyAccessUnlessGrantedCrud(Page::SHOW, $entity);

        $historyCollection = $historyManager->getHistory($entity, 1);

        return $this->render(
            '@whatwedoCrudHistory/history/history.html.twig',
            [
                'historyEntities' => $historyCollection,
                'entity' => $entity,
            ]
        );
    }
}
