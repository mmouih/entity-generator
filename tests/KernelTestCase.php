<?php

namespace EntityGenerator\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use EntityGenerator\Bridge\Symfony\ParameterBagInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class KernelTestCase extends TestCase
{
    private ?ContainerBuilder $container = null;

    public function setUp(): void
    {
        $param = $this->container()->get(ParameterBagInterface::class);
        $param->add(
            [
                'entity.generator' => [
                    'output.dir' => 'var/generated',
                    'namespace' => 'Entity\Generated',
                    'property.phpdoc' => true,
                    'property.type' => true # false before php7.4
                ]
            ]
        );
    }

    protected function container(): ContainerBuilder
    {
        if ($this->container instanceof ContainerBuilder) {
            return $this->container;
        }

        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container, new FileLocator('./config/'));
        $loader->load('services_test.yml');

        $this->container->compile();

        return $this->container;
    }
}
