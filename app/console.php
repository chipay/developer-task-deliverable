#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

//uncomment if to run indefinitely if needed (or set another time limit)
//set_time_limit(0);

require_once __DIR__.'/../vendor/autoload.php';

// Bootstrap the JMS custom annotations for Object mapping (serializatin/deserialization)
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
        'JMS\Serializer\Annotation',
        __DIR__.'/../vendor/jms/serializer/src'
);

$console = new Application("Date Utils Application", '1.0');

// Dependency injection support
$container = new ContainerBuilder();
$loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/config'));
$loader->load('services.xml');

// The command services have the "console.command" tag. Find them and add them to the app.
$commandServiceIds = $container->findTaggedServiceIds("console.command");

foreach ($commandServiceIds as $commandServiceId => $value) {
    $console->add($container->get($commandServiceId));
}

$console->run();
