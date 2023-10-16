<?php

namespace App\Command;

use App\Exception\EmptyStringException;
use App\Helper\FieldValidator;
use App\Helper\UniqueCharacters;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Helper\LetterSymbolsReverser;

class ReverseStringCommand extends Command
{
    public function configure()
    {
        $this->setDescription('Command for reverser string')
            ->setName('app:anagram')
            ->addOption('string', 's', InputOption::VALUE_REQUIRED, 'Enter the string')
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'Enter path to the file');
    }

    /**
     * @throws EmptyStringException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $optionString = $input->getOption('string');
        $optionFile = $input->getOption('file');
        $existFile = file_exists($optionFile ?? '');
        $fileContents = $existFile ? file_get_contents($optionFile, true) : "Path cannot be empty";
        $arrayWordsString = str_split($optionString);
        $arrayWordsFile = str_split($fileContents);
        $validatorString = new FieldValidator();
        $reverseString = new LetterSymbolsReverser($validatorString);
        $numbersSymbolString = new UniqueCharacters($arrayWordsString);
        $numbersSymbolStringFile = new UniqueCharacters($arrayWordsFile);

        if (!empty($optionString) && !$existFile) {
            $output->writeln('Reading string...');
            $output->writeln('Reversed string: ' . $reverseString->reverse($optionString));
            $output->writeln('Counting Unique Characters: ' . $numbersSymbolString->numberUniqueCharacters());
        } elseif (!empty($optionFile) && $existFile) {
            $output->writeln('Reading file...');
            $output->writeln('Reverse string in file: ' . $reverseString->reverse($fileContents));
            $output->writeln('Reverse string in file: ' . $numbersSymbolStringFile->numberUniqueCharacters());
        }
        if (empty($optionString) && empty($optionFile) && !$existFile) {
            $output->writeln('Please, enter path to file or enter sting');
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
