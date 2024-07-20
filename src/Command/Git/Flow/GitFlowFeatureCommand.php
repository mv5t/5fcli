<?php

namespace ToolCli\Command\Git\Flow;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'git:flow:feature',
    description: 'Add a short description for your command',
    aliases: ['g:f:f'],
)]
class GitFlowFeatureCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', "o", InputOption::VALUE_NONE, 'Option description')
            ->setHelp('this is helper')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $choice = $io->choice(
            'Que voulez vous faire',
            [
                'n'=>'Nouvelle feature',
                't'=>'Terminer une feature',
                'p'=>'Publier une feature',
                'r'=>'Récupérer une feature',
                's'=>'Suivre une feature',
            ]
        );
        $command = match ($choice) {
            'n' => 'git flow feature start ',
            't' => 'git flow feature finnish ',
            'p' => 'git flow feature publish ',
            'r' => 'git flow feature pull origin ',
            's' => 'git flow feature track ',

        };
        $nom = $io->ask('Nom de la feature');
        exec("$command $nom");
        $io->success('Ok.');
        return Command::SUCCESS;
    }
}
