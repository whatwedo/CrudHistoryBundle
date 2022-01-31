<?php

declare(strict_types=1);

namespace whatwedo\AuditorCrudExtensionBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use whatwedo\CrudBundle\DependencyInjection\Compiler\DefinitionPass;

class whatwedoAuditorCrudExtensionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
    }
}
