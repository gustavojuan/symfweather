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
    name: 'app:symfony-style',
    description: 'Demonstrate various styles',
)]
class SymfonyStyleCommand extends Command
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


        $io->writeln('This is writeln()');
        $io->title('This is a title');
        $io->section('This is a section');
        $io->note('This is a note');
        $io->caution('This is caution');


        $name = $io->ask('What is your name?');
        $output->writeln('Your name is ' . $name);

        $password = $io->askHidden('What is your password?');
        $output->writeln('Your password is ' . $password);

        $confirm = $io->confirm('Do you want to continue?');
        $output->writeln('Your confirmed password is ' . $confirm);

        $choice = $io->choice('What is your choice?', [1, 2, 3]);
        $output->writeln('Choice is ' . $choice);

        $items = ['apple', 'pear', 'banana'];
        $io->listing($items);

        $io->table(['Name', 'Country'], [
            ['Name', 'Country'],
            ['Name', 'Country'],

        ]);

        $io->progressStart(4);

        foreach ($items as $item) {
            $io->progressAdvance(1);
            sleep(2); // proceso
        }

        $io->progressFinish();

        return Command::SUCCESS;
    }
}
