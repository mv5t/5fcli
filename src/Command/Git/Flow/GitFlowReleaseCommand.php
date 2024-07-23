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
    name: 'git:flow:release',
    description: 'Gestion des releases du git flow',
    aliases: ['g:f:r'],
)]
class GitFlowReleaseCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', "o", InputOption::VALUE_NONE, 'Option description')
//            ->setHelp('this is helper')
//        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $choice = $io->choice(
            'Que voulez vous faire',
            [
                'n'=>'Nouvelle release',
                't'=>'Terminer une release',
                'p'=>'Publier une release',
                's'=>'Suivre une release',
            ]
        );
        $command = match ($choice) {
            'n' => 'git flow release start ',
            't' => 'git flow release finish ',
            'p' => 'git flow release publish ',
            's' => 'git flow release track ',

        };
        $nom = $io->ask('Nom de la release');
        $output->writeln("Lancement de la commande: $command $nom");
        exec("$command $nom");
        $io->success('Ok.');
        return Command::SUCCESS;
    }
}
