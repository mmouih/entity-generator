#!/usr/bin/env php
<?php
require __DIR__ . '/vendor/autoload.php';

use PayloadEntityGenerator\Application\BaseApplication;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator('./config/'));
$loader->load('services.yml');
$container->compile();

$application = $container->get(BaseApplication::class);
$application->run();
