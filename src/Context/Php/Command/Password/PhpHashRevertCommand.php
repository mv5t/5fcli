<?php

namespace ToolCli\Context\Php\Command\Password;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'php:password:infos',
    description: 'Obtenir les informations d\'un hash',
    aliases:['p:p:i'],
    hidden: false
)]
class PhpHashRevertCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $hash = $io->ask('A partir de quel hash obtenir des information');

        $infos = password_get_info($hash);
        $io->success([
            "Information provenant de {$hash}",
        ]);

        var_dump($infos);
        return Command::SUCCESS;
    }
}
