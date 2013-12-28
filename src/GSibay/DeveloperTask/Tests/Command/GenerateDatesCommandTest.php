<?php

namespace GSibay\DeveloperTask\Tests\Command;

//use Symfony\Component\Serializer\Serializer;
use JMS\Serializer\Serializer;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use GSibay\DeveloperTask\Command\GenerateDatesCommand;
use GSibay\DeveloperTask\Service\DateGeneratorService;

use \Mockery as m;

class GenerateDatesCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage Not enough arguments.
     */
    public function testCommand_NoArguments_ExceptionExpected()
    {
        $application = new Application();
        
        // get stubs for the service and the serializer
        $dateGeneratorService = m::mock('GSibay\DeveloperTask\Service\DateGeneratorService');
        $serializer = m::mock('JMS\Serializer\Serializer');//('Symfony\Component\Serializer\Serializer');
        
        $application->add(new GenerateDatesCommand($dateGeneratorService, $serializer));
        
        $command = $application->find(GenerateDatesCommand::COMMAND_NAME);
        $commandTester =  new CommandTester($command);
        
        $commandTester->execute(array('command' => $command->getName()));
    }

    /*
    public function testCommand_FileNameArgument_FileSaved()
    {
        $application = new Application();

        //TODO: mocks will have to be used when the command use the service
        // get stubs for the service and the serializer
        $dateGeneratorService = m::mock('GSibay\DeveloperTask\Service\DateGeneratorService');
        $serializer = m::mock('JMS\Serializer\Serializer');//m::mock('Symfony\Component\Serializer\Serializer');
        
        $application->add(new GenerateDatesCommand($dateGeneratorService, $serializer));
        
        $command = $application->find(GenerateDatesCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        
        $outputFileName = 'genDates';
        $commandTester->execute(array('command' => $command->getName(), GenerateDatesCommand::OUTPUT_FILE_NAME_ARG => $outputFileName));
        
        $this->assertEquals('File '.$outputFileName." generated\n", $commandTester->getDisplay(true));
    }
        TODO: MOCK THE CALL TO THE SERIALIZER TO RETURN WHATEVER.
    */
}
