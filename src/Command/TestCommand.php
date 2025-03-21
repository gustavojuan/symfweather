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
    name: 'app:test-command',
    description: 'This is a test command built with maker',
)]
class TestCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {

        //e app:test-command  -u Gus -u Bob
        $this
            //->addArgument('name',InputArgument::REQUIRED,'Name of the user to greet')

            ->addOption(
                'name',
                'u',
                InputOption::VALUE_REQUIRED  | InputOption::VALUE_IS_ARRAY,
                'Name of the user to greet',
                );
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $names = $input->getOption('name');
        $output->writeln("Hello ".implode(", ", $names));
        return Command::SUCCESS;
    }
}
