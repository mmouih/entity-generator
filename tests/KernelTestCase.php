<?php

namespace EntityGenerator\Tests;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class KernelTestCase extends TestCase
{
    private $container = null;
    protected function container(): ContainerInterface
    {
        if (null !== $this->container) {
            return $this->container;
        }

        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator('./config/'));
        $loader->load('services_test.yml');
        $container->compile();

        return $container;
    }
}
