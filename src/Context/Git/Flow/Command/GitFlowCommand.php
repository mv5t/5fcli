<?php

namespace ToolCli\Context\Git\Flow\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'git:flow',
    description: 'Add a short description for your command',
    aliases: ['g:f'],
)]
class GitFlowCommand extends Command
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
        $output->write("<fg=cyan>Pus d'information </>");
        $output->write('<fg=cyan;href=https://danielkummer.github.io/git-flow-cheatsheet/index.fr_FR.html>ICI</>');
        $io = new SymfonyStyle($input, $output);
        $hasToInit = $io->confirm('Initialiser un git flow ?');
        if ($hasToInit) {
            exec('git flow init -d');
            $io->success('Git Flow initialisé !');
            return Command::SUCCESS;
        }
        $io->warning('Rien a été modifié.');
        return Command::SUCCESS;
    }
}
