<?php

namespace GSibay\DeveloperTask\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use JMS\Serializer\SerializerInterface;
use GSibay\DeveloperTask\Service\DateTimeGeneratorService;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;
/**
 * This command generates dates
 * generates an XML file containing every 30th of June since
 * the Unix Epoch, at 1pm GMT, with the following format:
 *
 * <?xml version="1.0" encoding="UTF-8"?>
 *     <timestamp time="1246406400" text="2009-06-30 13:00:00" />
 * </timestamps>
 *
 * @author gsibay
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
     * @param JMS\Serializer\SerializerInterface                    $serializer
     * @param string                                                $serializeFormat      [optional] Format of the serialization.
     */
    public function __construct(DateTimeGeneratorService $dateGeneratorService, SerializerInterface $serializer, $serializeFormat = 'xml')
    {
        parent::__construct();
        $this->serializer = $serializer;
        $this->dateGeneratorService = $dateGeneratorService;
        $this->serializeFormat = "xml";
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
        ->setDescription("Generates an XML file containing every 30th of June since the Unix Epoch at 1PM GMT")
        ->addArgument(self::OUTPUT_FILE_NAME_ARG, InputArgument::REQUIRED, "Name of the output file")
        ->setHelp(<<<EOD
Generates an XML file containing every 30th of June since the Unix Epoch, at 1pm GMT, with the following format:
    <?xml version="1.0" encoding="UTF-8"?>
        <timestamp time="1246406400" text="2009-06-30 13:00:00" />
    </timestamps>
EOD
                );
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // create the dates, serialize them
        $generatedDates = $this->dateGeneratorService->generateDateTimesFromEpoch(new DateTime("now"), new DateTimeZone('GMT'));
        $serializedDates = $this->serializer->serialize($generatedDates, $this->serializeFormat);

        // write the serialized dates to the output file
        $outputFileName = $input->getArgument(self::OUTPUT_FILE_NAME_ARG);
        if (file_put_contents($outputFileName, $serializedDates) === false) {
           throw new \RuntimeException('Could not write to file: '.$outputFileName);
        }

        $output->writeln('File '.$outputFileName.' generated');
    }
}
