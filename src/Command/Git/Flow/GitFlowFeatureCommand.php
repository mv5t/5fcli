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
    description: 'Gestion des features du git flow',
    aliases: ['g:f:f'],
)]
class GitFlowFeatureCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $choice = $io->choice(
            'Que voulez vous faire',
            [
                'n'=>'Nouvelle feature (création d\'une nouvelle branche depuis develop)',
                't'=>'Terminer une feature (fusion avec la branche develop et suppression de la feature)',
                'p'=>'Publier une feature (push la feature)',
                's'=>'Suivre une feature (pull la feature)',
                'r'=>'Récupérer une feature (déprécié)',
            ]
        );
        $command = match ($choice) {
            'n' => 'git flow feature start ',
            't' => 'git flow feature finish ',
            'p' => 'git flow feature publish ',
            'r' => 'git flow feature pull origin ',
            's' => 'git flow feature track ',

        };
        $nom = $io->ask('Nom de la feature');
        $output->writeln("Lancement de la commande: $command $nom");
        exec("$command $nom");
        $io->success('Ok.');
        return Command::SUCCESS;
    }
}
