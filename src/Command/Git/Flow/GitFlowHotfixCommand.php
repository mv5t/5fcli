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
    name: 'git:flow:hotfix',
    description: 'Gestion des hotfix du git flow',
    aliases: ['g:f:h'],
)]
class GitFlowHotfixCommand extends Command
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
                'n'=>'Nouveau hotfix',
                't'=>'Terminer un hotfix',
            ]
        );
        $command = match ($choice) {
            'n' => 'git flow hotfix start ',
            't' => 'git flow hotfix finish '

        };
        $nom = $io->ask('Nom de la version');
        $output->writeln("Lancement de la commande: $command $nom");
        exec("$command $nom");
        $io->success('Ok.');
        return Command::SUCCESS;
    }
}
