<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Routing;

use araise\CrudBundle\Manager\DefinitionManager;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use whatwedo\CrudHistoryBundle\Controller\HistoryCrudController;
use whatwedo\CrudHistoryBundle\Page\HistoryPage;

class CrudHistoryLoader extends Loader
{
    private bool $isLoaded = false;

    public function __construct(
        protected DefinitionManager $definitionManager
    ) {
        parent::__construct();
    }

    public function load($resource, $type = null): RouteCollection
    {
        if ($this->isLoaded) {
            throw new \RuntimeException('Do not add the "whatwedo_crud" loader twice');
        }

        $routes = new RouteCollection();

        foreach ($this->definitionManager->getDefinitions() as $definition) {
            foreach ($definition::getCapabilities() as $capability) {
                if (in_array($capability, HistoryPage::cases(), true)) {
                    $route = new Route(
                        '/'.$definition::getRoutePathPrefix().'/',
                        [
                            '_resource' => $resource,
                            '_controller' => HistoryCrudController::class.'::'.$capability->toRoute(),
                        ]
                    );

                    switch ($capability) {
                        case HistoryPage::HISTORY:
                            $route->setPath($route->getPath().'{id}/history');
                            $route->setRequirement('id', '\d+');
                            break;
                    }

                    $routes->add($definition::getRoutePrefix().'_'.$capability->toRoute(), $route);
                }
            }
        }

        $this->isLoaded = true;

        return $routes;
    }

    /**
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return $type === 'whatwedo_crud_history';
    }
}
