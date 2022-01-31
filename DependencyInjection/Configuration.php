<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        return new TreeBuilder('whatwedo_crud_auditor');
    }
}
