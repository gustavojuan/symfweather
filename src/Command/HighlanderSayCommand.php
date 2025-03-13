<?php

namespace App\Command;

use App\Service\Highlander;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment;

#[AsCommand(
    name: 'highlander:say',
    description: 'Add a short description for your command',
)]
class HighlanderSayCommand extends Command
{
    public function __construct(
        private Highlander  $highlander,
        private Environment $twig)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('treshold', 't', InputOption::VALUE_REQUIRED, 'The treshold value', 50)
            ->addOption('trials', 'r', InputOption::VALUE_REQUIRED, 'The trial value', 10)
            ->addOption('csv', 'c', InputOption::VALUE_REQUIRED, 'The csv value', true);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $treshold = $input->getOption('treshold');
        $trials = $input->getOption('trials');
        $csv = $input->getOption('csv');

        $forecasts = $this->highlander->say($treshold, $trials);


        if ($csv) {
            $csv = $this->twig->render('weather/highlander_says.csv.twig', compact('forecasts','treshold'));
            $io->text($csv);
        }else{
            $io->listing($forecasts);
        }



        return Command::SUCCESS;
    }
}
