#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use JMS\Serializer\SerializerBuilder;
use GSibay\DeveloperTask\Command\GenerateDatesCommand;
use GSibay\DeveloperTask\Command\SortDatesExcludingPrimeYearsCommand;
use GSibay\DeveloperTask\Service\DefaultDateGeneratorService;
use Symfony\Component\Console\Tester\CommandTester;


// set to run indefinitely if needed
set_time_limit(0);

require_once __DIR__ . '/../vendor/autoload.php';

// Bootstrap the JMS custom annotations for Object mapping (serializatin/deserialization)
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
        'JMS\Serializer\Annotation',
        __DIR__.'/../vendor/jms/serializer/src'
);



$console = new Application("Date Utils Application", '1.0');

$dateGeneratorService = new DefaultDateGeneratorService();
//TODO esto sacarlo con dependency injection

$serializer = SerializerBuilder::create()->build();

$console ->add(new GenerateDatesCommand($dateGeneratorService, $serializer));
$console ->add(new SortDatesExcludingPrimeYearsCommand());
//$console->run();
$command = $console->find(GenerateDatesCommand::COMMAND_NAME);
$commandTester =  new CommandTester($command);
$commandTester->execute(array('command' => $command->getName()));
