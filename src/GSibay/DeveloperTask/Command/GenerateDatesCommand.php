<?php

/**
 * This file is part of the DeveloperTask package
 * 
 * @author gsibay
 */

namespace GSibay\DeveloperTask\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use JMS\Serializer\SerializerInterface;
use GSibay\DeveloperTask\Service\DateTimeGeneratorService;
use \DateTime as DateTime;

/**
 * Command to generate the dates and
 * and write them to the output file.
 * 
 * @author gsibay
 *
 */
class GenerateDatesCommand extends Command
{
    
    const OUTPUT_FILE_NAME_ARG = "output-file-name";
    const COMMAND_NAME = "generate-dates";
    
    /**
     * 
     * @var JMS\Serializer\SerializerInterface
     */
    private $serializer;
    
    /**
     * Format of the serialization. For instance 'xml'.
     * @var string
     */
    private $serializeFormat;    
    
    /**
     * 
     * @var GSibay\DeveloperTask\Service\DateTimeGeneratorService
     */
    private $dateGeneratorService;
    
    /**
     * Constructor. 
     * 
     * @param GSibay\DeveloperTask\Service\DateTimeGeneratorService $dateGeneratorService
     * @param JMS\Serializer\SerializerInterface $serializer
     * @param string $serializeFormat [optional] Format of the serialization.
     */
    public function __construct(DateTimeGeneratorService $dateGeneratorService, SerializerInterface $serializer, $serializeFormat = 'xml')
    {
        parent::__construct();
        $this->serializer = $serializer;
        $this->dateGeneratorService = $dateGeneratorService;
        $this->serializeFormat = 'xml';
    }

    /**
     * Getter
     * @return JMS\Serializer\SerializerInterface
     */
    private function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @return GSibay\DeveloperTask\Service\DateTimeGeneratorService
     */
    private function getDateGeneratorService()
    {
        return $this->dateGeneratorService;
    }
    
    /**
     * @return string 
     */
    private function getSerializeFormat()
    {
        return $this->serializeFormat;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this->setName(GenerateDatesCommand::COMMAND_NAME)
        ->setDescription("Generates a file with dates as requested by the spec")
        ->addArgument(GenerateDatesCommand::OUTPUT_FILE_NAME_ARG, InputArgument::REQUIRED, "Name of the output file")
        ->setHelp("The <info>generate-dates</info> command generate a file with the dates as specified");
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // create the dates, serialize them and write to the file
        $generatedDates = $this->getDateGeneratorService()->generateDateTimesFromEpoch(new DateTime());
        $serializedDates = $this->getSerializer()->serialize($generatedDates, $this->getSerializeFormat());
        
        $outputFileName = $input->getArgument(GenerateDatesCommand::OUTPUT_FILE_NAME_ARG);
        file_put_contents($outputFileName, $serializedDates);
        $output->writeln('File '.$outputFileName.' generated');
    }
}
