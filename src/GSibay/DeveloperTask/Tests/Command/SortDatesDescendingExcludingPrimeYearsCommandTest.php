<?php

namespace GSibay\DeveloperTask\Tests\Command;

use GSibay\DeveloperTask\Command\SortDatesDescendingExcludingPrimeYearsCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use \Mockery as M;

class SortDatesDescendingExcludingPrimeYearsCommandTest extends \PHPUnit_Framework_TestCase
{
    const TEST_INPUT_FILE_NAME = "input.test";
    const TEST_OUTPUT_FILE_NAME = "output.test";

    public function getTestInputFileName()
    {
        return __DIR__ . self::TEST_INPUT_FILE_NAME;
    }

    public function getTestOutputFileName()
    {
        return __DIR__ . self::TEST_OUTPUT_FILE_NAME;
    }

    public function tearDown()
    {
        $input = $this->getTestInputFileName();
        $output = $this->getTestOutputFileName();

        if (file_exists($input)) {
            unlink($input);
        }

        if (file_exists($output)) {
            unlink($output);
        }
    }

    private function createCommandWithDummyServices()
    {
        $application = new Application();

        // create dummies for the service and the serializer
        $arrayOrganizerService = M::mock('GSibay\DeveloperTask\Service\ArrayOrganizerService');
        $serializer = M::mock('JMS\Serializer\SerializerInterface');

        $application->add(new SortDatesDescendingExcludingPrimeYearsCommand($arrayOrganizerService, $serializer));

        return $application->find(SortDatesDescendingExcludingPrimeYearsCommand::COMMAND_NAME);
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage Not enough arguments.
     */
    public function testCommand_NoArguments_ExceptionExpected()
    {
        $command = $this->createCommandWithDummyServices();
        (new CommandTester($command))->execute(array('command' => $command->getName()));
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage Not enough arguments.
     */
    public function testCommand_OnlyInputFileArgumentMissing_ExceptionExpected()
    {
        $command = $this->createCommandWithDummyServices();
        (new CommandTester($command))->execute(array('command' => $command->getName(), SortDatesDescendingExcludingPrimeYearsCommand::INPUT_FILE_NAME_ARG => 'input'));
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage Not enough arguments.
     */
    public function testCommand_OnlyOutputFileArgumentMissing_ExceptionExpected()
    {
        $command = $this->createCommandWithDummyServices();
        (new CommandTester($command))->execute(array('command' => $command->getName(), SortDatesDescendingExcludingPrimeYearsCommand::OUTPUT_FILE_NAME_ARG => 'output'));
    }

    public function testCommand_BothArgumentsProvided_FileReadProcessedAndSaved()
    {
        // initialize the input file for the test
        $inputFileName = $this->getTestInputFileName();
        file_put_contents($inputFileName, 'dummy serialized data');
        $inputFileContent = file_get_contents($inputFileName);

        // set dummy values for the objects returned by the mocks
        $outputFileName = $this->getTestOutputFileName();
        $dummyDeserializedArray = array('an object', 'another object', 'yet another one');
        $organizedArray = array('this', 'array', 'is', 'organized');
        $organizedAndSerializedData = 'This is the final product after organization and serialization';

        // get mocks
        $mockedArrayOrganizerService = M::mock('GSibay\DeveloperTask\Service\ArrayOrganizerService');
        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');

        $mockedSerializer->shouldReceive('deserialize')->once()->with($inputFileContent, 'array', 'xml')->ordered()->andReturn($dummyDeserializedArray);
        $mockedArrayOrganizerService->shouldReceive('organize')->with($dummyDeserializedArray)->once()->ordered()->andReturn($organizedArray);
        $mockedSerializer->shouldReceive('serialize')->once()->with($organizedArray,'xml')->ordered()->andReturn($organizedAndSerializedData);

        // Set the application with the command tester and execute it
        $application = new Application();
        $application->add(new SortDatesDescendingExcludingPrimeYearsCommand($mockedArrayOrganizerService, $mockedSerializer));
        $command = $application->find(SortDatesDescendingExcludingPrimeYearsCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName(), SortDatesDescendingExcludingPrimeYearsCommand::INPUT_FILE_NAME_ARG => $inputFileName,
                SortDatesDescendingExcludingPrimeYearsCommand::OUTPUT_FILE_NAME_ARG => $outputFileName));

        //read the file created by the command, then delete the files created for this test and finally check the result is as expected
        $contentOfOutputFile = file_get_contents($outputFileName);

        $this->assertEquals($contentOfOutputFile, $organizedAndSerializedData);
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage Input file is not valid.
     */
    public function testCommand_BothArgumentsProvidedValidatorSetAndInvalidInput_RuntimeExceptionExpected()
    {
        // initialize the input file for the test
        $inputFileName = $this->getTestInputFileName();
        file_put_contents($inputFileName, 'dummy serialized data');
        $inputFileContent = file_get_contents($inputFileName);

        $outputFileName = $this->getTestOutputFileName();

        // get mocks
        $mockedArrayOrganizerService = M::mock('GSibay\DeveloperTask\Service\ArrayOrganizerService');
        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
        $mockedValidator = M::mock('GSibay\DeveloperTask\Validator\Validator');

        $mockedValidator->shouldReceive('validate')->once()->with($inputFileContent)->ordered()->andReturn(false);

        // Set the application with the command tester and execute it
        $application = new Application();
        $application->add(new SortDatesDescendingExcludingPrimeYearsCommand($mockedArrayOrganizerService, $mockedSerializer, $mockedValidator));
        $command = $application->find(SortDatesDescendingExcludingPrimeYearsCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName(), SortDatesDescendingExcludingPrimeYearsCommand::INPUT_FILE_NAME_ARG => $inputFileName,
                SortDatesDescendingExcludingPrimeYearsCommand::OUTPUT_FILE_NAME_ARG => $outputFileName));

        $this->assertEquals($contentOfOutputFile, $organizedAndSerializedData);
    }

}
