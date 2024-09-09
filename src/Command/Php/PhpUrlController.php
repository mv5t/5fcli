<?php

namespace ToolCli\Command\Php;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'php:url',
    description: 'Outil PHP pour encoder/decoder une url',
    aliases:['p:u'],
    hidden: false
)]
class PhpUrlController extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $choice = $io->choice(
        'Que voulez vous faire ?',
            [
                'e'=>'Encoder',
                'd'=>'Décoder'
            ],'d'
        );
        $plain = $io->ask('Quelle chaine de caractère');
        $hash = match ($choice) {
            'd' => urldecode($plain),
            default => urlencode($plain),
        };

        $io->success([
            "Entrée {$plain}",
            "Sortie : {$hash}"
        ]);
        return Command::SUCCESS;
    }
}
