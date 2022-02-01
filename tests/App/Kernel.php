<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests\App;

use DH\AuditorBundle\DHAuditorBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use whatwedo\CoreBundle\Manager\FormatterManager;
use whatwedo\CoreBundle\whatwedoCoreBundle;
use whatwedo\CrudHistoryBundle\Manager\FilterManager;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudHistoryBundle\Manager\SearchManager;
use whatwedo\CrudHistoryBundle\Tests\App\Repository\CompanyRepository;
use whatwedo\CrudHistoryBundle\Tests\App\Repository\ContactRepository;
use whatwedo\CrudHistoryBundle\whatwedoCrudHistoryBundle;
use Zenstruck\Foundry\ZenstruckFoundryBundle;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__) . '/App';
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getProjectDir() . '/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', \PHP_VERSION_ID < 70400 || $this->debug);
        $container->setParameter('container.dumper.inline_factories', true);

        $confDir = $this->getProjectDir() . '/config';
        $loader->load($confDir . '/{packages}/*' . self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $confDir = $this->getProjectDir() . '/config';

        $routes->import($confDir . '/routes/*' . self::CONFIG_EXTS, 'glob');
    }
}
