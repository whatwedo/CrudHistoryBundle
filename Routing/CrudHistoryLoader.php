<?php

declare(strict_types=1);

namespace whatwedo\AuditorCrudExtensionBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use whatwedo\AuditorCrudExtensionBundle\Controller\HistoryCrudController;
use whatwedo\CrudBundle\Enum\Page;
use whatwedo\CrudBundle\Manager\DefinitionManager;

class CrudHistoryLoader extends Loader
{
    private bool $isLoaded = false;

    public function __construct(
        protected DefinitionManager $definitionManager
    )
    {
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
                if ($capability === 'history') {
                    $route = new Route(
                        '/' . $definition::getRoutePathPrefix() . '/',
                        [
                            '_resource' => $resource,
                            '_controller' => HistoryCrudController::class . '::history',
                        ]
                    );

                    $route->setPath($route->getPath() . '{id}/history');
                    $route->setRequirement('id', '\d+');

                    $routes->add($definition::getRoutePrefix() . '_history', $route);
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
        return 'whatwedo_crud_history' === $type;
    }
}
