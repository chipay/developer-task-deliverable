#!/usr/bin/env php
<?php

use GSibay\DeveloperTask\Command\GenerateDatesCommand;
use GSibay\DeveloperTask\Command\SortDatesExcludingPrimeYearsCommand;
use GSibay\DeveloperTask\Service\DefaultDateTimeGeneratorService;
use GSibay\DeveloperTask\DateTime\DateTimeUtils;
use Symfony\Component\Console\Application;
use JMS\Serializer\SerializerBuilder;

// set to run indefinitely if needed
set_time_limit(0);

require_once __DIR__ . '/../vendor/autoload.php';

// Bootstrap the JMS custom annotations for Object mapping (serializatin/deserialization)
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
        'JMS\Serializer\Annotation',
        __DIR__.'/../vendor/jms/serializer/src'
);



$console = new Application("Date Utils Application", '1.0');

//TODO: add dependency injection
$dateGeneratorService = new DefaultDateTimeGeneratorService(new DateTimeUtils());

//TODO add dependency injection
$serializer = SerializerBuilder::create()->build();

$console->add(new GenerateDatesCommand($dateGeneratorService, $serializer));
// TODO: ADD the other command
//$console->add(new SortDatesExcludingPrimeYearsCommand());
$console->run();
