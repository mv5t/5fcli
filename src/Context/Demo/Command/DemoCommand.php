<?php

namespace ToolCli\Context\Demo\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'demo',
    description: 'Commande de démonstration',
)]
class DemoCommand extends Command
{
    protected function configure()
    {
        $this
            ->setHelp('Aide de la commande de démonstration');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->success('Commande de démonstration essayer demo:argument');
        return command::SUCCESS;
    }
}
