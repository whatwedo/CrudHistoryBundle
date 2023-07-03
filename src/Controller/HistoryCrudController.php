<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Controller;

use araise\CrudBundle\Controller\CrudController;
use araise\CrudBundle\Enums\Page;
use araise\CrudBundle\Manager\DefinitionManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudHistoryBundle\Page\HistoryPage;

class HistoryCrudController extends CrudController
{
    public function history(Request $request, HistoryManager $historyManager, DefinitionManager $definitionManager): Response
    {
        $entity = $this->getEntityOr404($request);
        $this->denyAccessUnlessGrantedCrud(Page::SHOW, $entity);

        $transactionList = $historyManager->getHistory($entity, 1);

        $this->definition->buildBreadcrumbs($entity, Page::SHOW);

        $this->definition->getBreadcrumbs()->addRouteItem('whatwedo_crud_history.breadcrumb', $this->definition::getRoute(HistoryPage::HISTORY), [
            'id' => $entity->getId(),
        ]);

        return $this->render(
            '@whatwedoCrudHistory/history/history.html.twig',
            [
                'wwd_crud_enable_breadcrumbs' => true,
                'transactionList' => $transactionList,
                'entity' => $entity,
                'entityTitle' => $this->definition::getEntityTitle(),
            ]
        );
    }
}
