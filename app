#!/usr/bin/env php
<?php
/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
require __DIR__ . '/vendor/autoload.php';

use EntityGenerator\BaseApplication;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator('./config/'));
$loader->load('services.yml');
$container->compile();

/** @var BaseApplication $application*/
$application = $container->get(BaseApplication::class);
$application->run();
