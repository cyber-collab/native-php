<?php

namespace App\Command;

use App\Exception\NotFoundRacerException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Helper\RacerReport;

class RacerReportCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:report')
            ->setDescription('Generates a report of the top and bottom racers')
            ->addOption('files', null, InputOption::VALUE_REQUIRED, 'Path to the files')
            ->addOption('asc', null, InputOption::VALUE_NONE, 'Sort racers in ascending order')
            ->addOption('desc', null, InputOption::VALUE_NONE, 'Sort racers in descending order')
            ->addOption('driver', null, InputOption::VALUE_REQUIRED, 'Name of the driver to show statistics for')
            ->setHelp('This command generates a report of the top and bottom racers based on the specified files');
    }

    /**
     * @throws NotFoundRacerException
     *
     * Example execute command php bin/console app:report --files ./files/
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = $input->getOption('files');
        $asc = $input->getOption('asc');
        $desc = $input->getOption('desc');
        $driverName = $input->getOption('driver');

        if (!$files) {
            $output->writeln('<error>Please provide the path to the files using the --files option</error>');
            return Command::FAILURE;
        }

        $racersFile = $files . 'abbreviations.txt';
        $timesFile = $files . 'end.log';

        if (!file_exists($racersFile) || !file_exists($timesFile)) {
            $output->writeln('<error>One or both of the specified files do not exist</error>');
            return Command::FAILURE;
        }

        $report = new RacerReport($racersFile, $timesFile);

        if ($driverName) {
            $racer = $report->getRacerByName($driverName);

            if (!$racer) {
                $output->writeln(sprintf('<error>No racer found with the name "%s"</error>', $driverName));
                return Command::FAILURE;
            }

            $output->writeln(sprintf('Statistics for %s', $racer['name']));
            $output->writeln(sprintf('Team: %s', $racer['team']));
            $output->writeln(sprintf('Best lap time: %s', $racer['time'] ? gmdate('H:i:s', $racer['time']) : '-'));
        } else {
            if ($asc) {
                $racers = $report->getTopRacers();
            } elseif ($desc) {
                $racers = $report->getLosersRacers();
            } else {
                $racers = $report->getTopRacers();
            }

            $i = 1;
            foreach ($racers as $racer) {
                $output->write($i++ . '. ');
                $output->writeln(sprintf('%-20s | %-30s | %s', $racer['name'], $racer['team'], $racer['time'] ? gmdate('H:i:s', $racer['time']) : '-'));
            }
        }

        return Command::SUCCESS;
    }
}
