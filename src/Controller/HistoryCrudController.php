<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudBundle\Controller\CrudController;
use whatwedo\CrudBundle\Enum\Page;
use whatwedo\CrudBundle\Manager\DefinitionManager;

class HistoryCrudController extends CrudController
{
    public function history(Request $request, HistoryManager $historyManager, DefinitionManager $definitionManager): Response
    {
        $entity = $this->getEntityOr404($request);
        $this->denyAccessUnlessGrantedCrud(Page::SHOW, $entity);

        $definition =  $definitionManager->getDefinitionByEntity($entity);
        $historyDefinition = $definition->getHistoryDefinition();
        $def = new $historyDefinition();
        $historyCollection = $historyManager->getHistory($entity, $definition);
//        $pagination->setTemplate('history/sliding.html.twig');

        return $this->render(
            '/history/history.html.twig',
            [
                'historyEntities' => $historyCollection,
                'entity' => $entity,
            ]
        );
    }
}
