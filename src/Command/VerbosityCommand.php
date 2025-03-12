<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:verbosity',
    description: 'Add a short description for your command',
)]
class VerbosityCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        $io->writeln('This is the writeln');

        if($io->isVerbose()) {
            $io->writeln('This is verbose');
        }

        if($io->isVeryVerbose()) {
            $io->writeln('This is very verbose');
        }

        if($io->isDebug()) {
            $io->writeln('This is debug');
        }

        $output->writeln('This is the writeln');

        if($output->isVerbose()) {
            $output->writeln('This is verbose');
        }

        if($output->isVeryVerbose()) {
            $output->writeln('This is very verbose');
        }

        if($output->isDebug()) {
            $output->writeln('This is debug');
        }




        return Command::SUCCESS;
    }
}
