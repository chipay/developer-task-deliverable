<?php

/**
 * This file is part of the DeveloperTask package
 * 
 * @author gsibay
 */

namespace GSibay\DeveloperTask\Command;

use Symfony\Component\Console\Input\ArrayInput;

use Symfony\Component\Console\Input\InputArgument;

use GSibay\DeveloperTask\Service\DateGeneratorService;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
//use Symfony\Component\Serializer\Serializer;
use JMS\Serializer\Serializer;
use GSibay\DeveloperTask\Serializer\SerializableTimeDates;
use JMS\Serializer\SerializerBuilder;

use \DateTime;

//TODO: Agregar Serializer comun y ver si puedo usar con array(DateTime). Ver si ahi puedo 
//definir mi propio normalizer o lo que sea y eso funciona
// Si todo esto falla puedo crear una clase propia DateTimes que tenga dentro un array de DateTime y eso
// va  aser mas facil para todo. De hecho eso puedo usar un ArrayCollection y usar filter y 
// quizas algo para ordernarlo. Por ahi eso es lo mejor.
// Hago que mi funcion devuelva un ArrayCollection pero luego pongo una implementacion
// que tiene la configuracion de como se serializa! eso es lo mejor. La configuracion
// esta en las anotations. Luego serializo. Probar eso.


/**
 * Command to generate and save the dates
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
     * @var JMS\Serializer\Serializer
     */
    private $serializer;
    
    /**
     * 
     * @var GSibay\DeveloperTask\DateGenerator
     */
    private $dateGeneratorService;
    
    /**
     * Constructor 
     * 
     * @param DateGeneratorService $dateGeneratorService
     * @param JMS\Serializer\Serializer $serializer
     */
    public function __construct(DateGeneratorService $dateGeneratorService, Serializer $serializer)
    {
        parent::__construct();
        $this->setSerializer($serializer);
        $this->setDateGeneratorService($dateGeneratorService);
    }

    /**
     * Setter
     * @param Serializer $serializer
     */
    private function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }
    
    /**
     * Getter
     * @return Serializer
     */
    private function getSerializer()
    {
        return $this->serializer;
    }
    
    /**
     * Setter
     * @param DateGeneratorService $dateGeneratorService
     */
    private function setDateGeneratorService(DateGeneratorService $dateGeneratorService)
    {
        $this->dateGeneratorService = $dateGeneratorService;
    }
    
    /**
     * Getter
     */
    private function getDateGeneratorService()
    {
        return $this->dateGeneratorService;
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
        //->setDefinition(array())
        ->setHelp("The <info>generate-dates</info> command generate a file with the dates as specified");
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        //$dates = array(new DateTime(), new DateTime());
        // TODO sacar esto a un serializador donde este configurado el handler que usa y que es xml
        //$serialized = $this->getSerializer()->serialize($dates, 'xml');        
        //echo $serialized;
        
        ///
        $serializer = SerializerBuilder::create()->setDebug(true)->build();
        $date = new DateTime('1980-10-29');
        $dates = array($date, new DateTime('1990-10-29'));
        var_dump("before serialization: ");
        var_dump($dates);
        var_dump("normal serialization: ");
        $normalSerialization = $serializer->serialize($dates, 'xml');
        var_dump($normalSerialization);
        
        var_dump("deserialization: ");
        $dates = $serializer->deserialize($normalSerialization, "array<DateTime>", 'xml');
        var_dump($dates);
        
        //$object = simplexml_load_string($normalSerialization);
        
        //$serializer->d
        //$serializableDates = new SerializableTimeDates($dates);
        //simplexml_load_string($data);
        //var_dump($serializableDates);
        //$serializableDates->setDates($dates);
        
        
        //$serialized = $serializer->serialize($serializableDates, 'xml');
        //var_dump($serialized);
        
        ///
        //$outputFileName = $input->getArgument(GenerateDatesCommand::OUTPUT_FILE_NAME_ARG);
        // write to file system
        //$output->writeln('File '.$outputFileName.' generated');
    }
}
