<?php

namespace ToolCli\Command\Demo;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'demo:argument',
    description: 'Demo argument command',
    aliases:['d:a'],
    hidden: false
)]
class DemoArgumentCommand extends Command
{
    protected function configure()
    {
        $this
            ->setHelp('demo:argument prenom nom --option1 -c')
            ->addArgument('prenom', InputArgument::REQUIRED, 'prenom')
            ->addArgument('nom', InputArgument::OPTIONAL, 'nom')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'option 1')
            ->addOption('iteration', 'i', InputOption::VALUE_OPTIONAL, 'Nombre de fois à répéter')
            ->addUsage('demo:argument Mathieu VIOT')
            ->addUsage('demo:argument Mathieu VIOT --option1 -i5')
            ->addUsage('d:a Mathieu VIOT --iteration=5')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $nom = $input->getArgument('nom');
        $prenom = $input->getArgument('prenom');
        $output->writeln("<fg=green;options=bold,underscore>Bonjour $prenom $nom</>");
        if($input->getOption('option1')) {
            $output->writeln("<fg=black;bg=yellow;options=bold,underscore>Option 1 ok</>");
        }
        if($input->getOption('iteration')) {
            for ($i = 1; $i <= $input->getOption('iteration'); $i++) {
                $output->writeln("<fg=black;bg=cyan;options=bold,underscore>Itération $i</>");
            }

        }
        return Command::SUCCESS;
    }
}
