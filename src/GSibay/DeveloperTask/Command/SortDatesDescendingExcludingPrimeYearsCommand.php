<?php

namespace GSibay\DeveloperTask\Command;

use Symfony\Component\Console\Input\InputArgument;
use GSibay\DeveloperTask\Service\ArrayOrganizerService;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use JMS\Serializer\SerializerInterface;
use \DOMDocument as DOMDocument;

/**
 * Command to parse a file into an array and
 * organize it (sort and filter). The result
 * is serialized and stored in the output file.
 *
 * @author gsibay
 *
 */
class SortDatesDescendingExcludingPrimeYearsCommand extends Command
{
    const COMMAND_NAME = 'sort-dates-epy';
    const OUTPUT_FILE_NAME_ARG = 'output-file-name';
    const INPUT_FILE_NAME_ARG = 'input-file-name';

    /**
     * The serializer to serialize and deserialize the dates
     * @var JMS\Serializer\SerializerInterface
     */
    private $serializer;

    /**
     * The service to sort the dates in descending order
     * and excluding prime years
     * @var GSibay\DeveloperTask\Arrays\ArrayOrganizerService
     */
    private $arrayOrganizerService;

    /**
     * Format of the serialization. For instance 'xml'.
     * @var string
     */
    private $serializeFormat;

    /**
     * The file containing the schema to validate the xml input
     * @var string
     */
    private $schemaForValidationFileName;
    
    /**
     * 
     * @param ArrayOrganizerService $arrayOrganizerService
     * @param SerializerInterface $serializer
     * @param string $serializeFormat
     * @param string $schemaForValidationFileName
     * @throws \RuntimeException
     */
    public function __construct(ArrayOrganizerService $arrayOrganizerService, SerializerInterface $serializer, $schemaForValidationFileName = null, $serializeFormat = 'xml')
    {
        parent::__construct();
        $this->serializer = $serializer;
        $this->arrayOrganizerService = $arrayOrganizerService;
        $this->serializeFormat = 'xml';
        $this->schemaForValidationFileName = $schemaForValidationFileName;
    }

    private function validateXMLFile($xmlStr)
    {
        if($this->schemaForValidationFileName !== null) {
            $xml= new DOMDocument();
            $xml->loadXML($xmlStr, LIBXML_NOBLANKS);
            if(!$xml->schemaValidate($this->schemaForValidationFileName)) {
                throw new \RuntimeException("Input file is not valid according to schema " . $this->schemaForValidationFileName); 
            }
        }
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
        ->setDescription('Parses the dates from the input xml file and sorts them excluding years that are prime numbers. The result is transformed
                to PST timezone and set to 13:00:00. The result is saved to the output file.')
        ->addArgument(self::INPUT_FILE_NAME_ARG, InputArgument::REQUIRED, "Name of the input file.")
        ->addArgument(self::OUTPUT_FILE_NAME_ARG, InputArgument::REQUIRED, "Name of the output file.")
        ->setHelp("The <info>sort-dates-epy</info> command parses the input file and creates an output file with
                the dates sorted excluding years that are prime numbers. The output file will have those dates but transformed by changing the timezone to PST, 
                setting the time to 13:00:00 PST.");
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // read the input file and deserialize the data
        $fileContent = file_get_contents($input->getArgument(self::INPUT_FILE_NAME_ARG));
        if ($fileContent === false) {
            throw new \RuntimeException('Could not read input file: '.$input->getArgument(self::INPUT_FILE_NAME_ARG));
        }

        // validate the xml
        $this->validateXMLFile($fileContent); 
        
        $dates = $this->serializer->deserialize($fileContent, 'array', $this->serializeFormat);

        // sort and filter the dates
        $organizedDates =$this->arrayOrganizerService->organize($dates);

        // serialize the organized dates
        $serializedOrganizedDates = $this->serializer->serialize($organizedDates, $this->serializeFormat);

        // write the serialized data to the output file
        $outputFileName = $input->getArgument(self::OUTPUT_FILE_NAME_ARG);
        if (file_put_contents($outputFileName, $serializedOrganizedDates) === false) {
            throw new \RuntimeException('Could not write to output file: '.$input->getArgument(self::OUTPUT_FILE_NAME_ARG));
        }
        $output->writeln('File '.$outputFileName.' generated');
    }
}
