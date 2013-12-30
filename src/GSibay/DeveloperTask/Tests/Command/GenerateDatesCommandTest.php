<?php

namespace GSibay\DeveloperTask\Tests\Command;

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

        // create dummies for the service and the serializer
        $dateGeneratorService = m::mock('GSibay\DeveloperTask\Service\DateTimeGeneratorService');
        $serializer = m::mock('JMS\Serializer\SerializerInterface');

        $application->add(new GenerateDatesCommand($dateGeneratorService, $serializer));

        $command = $application->find(GenerateDatesCommand::COMMAND_NAME);
        $commandTester =  new CommandTester($command);

        $commandTester->execute(array('command' => $command->getName()));
    }

    public function testCommand_FileNameArgument_FileSaved()
    {
        $application = new Application();

        // get mocks
        $dateGeneratorServiceMock = m::mock('GSibay\DeveloperTask\Service\DateTimeGeneratorService');
        $serializerMock = m::mock('JMS\Serializer\SerializerInterface');

        $dateGeneratorServiceMock->shouldReceive('generateDateTimesFromEpoch')->once()->andReturn('generatedDates');
        $serializerMock->shouldReceive('serialize')->once()->with('generatedDates','xml')->andReturn('serializedData');

        //test the file was created

        /**
        $mock->shouldReceive(‘divertPower’)->with(0.40, ‘sensors’)->once()->ordered();
        $mock->shouldReceive(‘divertPower’)->with(0.30, ‘auxengines’)->once()->ordered();
        $mock->shouldReceive(‘runDiagnosticLevel’)->with(1)->once()->andReturn(true)->ordered();
        $mock->shouldReceive(‘runDiagnosticLevel’)->with(M::type(‘int’))->zeroOrMoreTimes();
        */
        //$starship = new Starship($mock);
        //$this->assertTrue($starship->enterOrbit());

        $application->add(new GenerateDatesCommand($dateGeneratorServiceMock, $serializerMock));

        $command = $application->find(GenerateDatesCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);

        //TODO: save test files in another dir
        $outputFileName = __DIR__ . 'genDatesCommand.test';
        $commandTester->execute(array('command' => $command->getName(), GenerateDatesCommand::OUTPUT_FILE_NAME_ARG => $outputFileName));

        // get the content of the file and delete it
        $contentOfOutputFile = file_get_contents($outputFileName);
        unlink($outputFileName);

        $this->assertEquals('serializedData', $contentOfOutputFile);
        // TODO test this as another test $this->assertEquals('File '.$outputFileName." generated\n", $commandTester->getDisplay(true));
    }

}
