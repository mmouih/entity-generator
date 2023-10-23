<?php

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator('./config/'));
$loader->load('services_test.yml');
$container->compile();
