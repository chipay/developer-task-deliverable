#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use JMS\Serializer\SerializerBuilder;
use GSibay\DeveloperTask\Command\GenerateDatesCommand;
use GSibay\DeveloperTask\Command\SortDatesExcludingPrimeYearsCommand;
use GSibay\DeveloperTask\Service\DefaultDateTimeGeneratorService;
use GSibay\DeveloperTask\DateTime\DateTimeUtils;

// set to run indefinitely if needed
//set_time_limit(0);

require_once __DIR__.'/../vendor/autoload.php';

// Bootstrap the JMS custom annotations for Object mapping (serializatin/deserialization)
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
        'JMS\Serializer\Annotation',
        __DIR__.'/../vendor/jms/serializer/src'
);

$console = new Application("Date Utils Application", '1.0');

// adds dependency injection support
$container = new ContainerBuilder();
$loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/config'));
$loader->load('services.xml');

$dateGeneratorService = new DefaultDateTimeGeneratorService(new DateTimeUtils());

$serializer = SerializerBuilder::create()->build();

$console->add(new GenerateDatesCommand($dateGeneratorService, $serializer));
// TODO: ADD the other command
//$console->add(new SortDatesExcludingPrimeYearsCommand());
$console->run();
