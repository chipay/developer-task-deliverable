<?php

namespace GSibay\DeveloperTask\Tests\Command;

use JMS\Serializer\Serializer;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use GSibay\DeveloperTask\Command\GenerateDatesCommand;
use GSibay\DeveloperTask\Service\DateGeneratorService;
use \Mockery as M;

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
        $dateGeneratorService = M::mock('GSibay\DeveloperTask\Service\DateTimeGeneratorService');
        $serializer = M::mock('JMS\Serializer\SerializerInterface');

        $application->add(new GenerateDatesCommand($dateGeneratorService, $serializer));

        $command = $application->find(GenerateDatesCommand::COMMAND_NAME);
        $commandTester =  new CommandTester($command);

        $commandTester->execute(array('command' => $command->getName()));
    }

    public function testCommand_FileNameArgument_FileSaved()
    {
        $application = new Application();

        // get mocks
        $dateGeneratorServiceMock = M::mock('GSibay\DeveloperTask\Service\DateTimeGeneratorService');
        $serializerMock = M::mock('JMS\Serializer\SerializerInterface');

        $dateGeneratorServiceMock->shouldReceive('generateDateTimesFromEpoch')->once()->ordered()->andReturn('generatedDates');
        $serializerMock->shouldReceive('serialize')->once()->with('generatedDates','xml')->ordered()->andReturn('serializedData');

        //test that the file was created
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
    }

}
