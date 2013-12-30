<?php

/**
 * This file is part of the DeveloperTask package
 *
 * @author gsibay
 */

namespace GSibay\DeveloperTask\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Serializer\Serializer;

/**
 * Command to parse a file with dates
 * to be stored in another file
 * sorted and excluding years that are
 * prime numbers
 *
 * @author gsibay
 *
 */
class SortDatesExcludingPrimeYearsCommand extends Command
{
    /**
     *
     * @var Symfony\Component\Serializer\Serializer
     */
    protected $serializer;

    /**
     *
     * @var GSibay\DeveloperTask\DateGenerator
     */
    protected $organiser;

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this->setName("sort-dates-epy")
        ->setDescription("Parses the dates from the input file and sorts them excluding years that are prime numbers. The result is
                saved to the output file")
        ->setDefinition(array())
        ->setHelp("The <info>sort-dates-epy</info> command parses the input file and creates an output file with
                the dates sorted excluding years that are prime numbers");
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(array("Command executed successfuly"));
    }
}
