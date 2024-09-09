<?php

namespace ToolCli\Command\Php\Password;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'php:password:hash',
    description: 'Outil PHP pour encoder un chaine de caractère',
    aliases:['p:p:h'],
    hidden: false
)]
class PhpHashController extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $plain = $io->ask('Que voulez vous encoder');

        $choice = $io->choice(
            'Quel algo ?',
            [
                '0'=>'DEFAULT',
                '1'=>'BCRYPT',
                '2'=>'BCRYPT_DEFAULT_COST',
                '3'=>'ARGON2I',
                '4'=>'PASSWORD_ARGON2_DEFAULT_MEMORY_COST',
            ],'0'
        );
        $io->info($choice);
        $algo = match ($choice) {
            '0', 'DEFAULT' => PASSWORD_DEFAULT,
            '1' => PASSWORD_BCRYPT,
            '2' => PASSWORD_BCRYPT_DEFAULT_COST,
            '3' => PASSWORD_ARGON2I,
            '4' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,

        };
        $hash = password_hash($plain,$algo);
        $io->success([
            "Vous avez encodé {$plain}",
            "Qui devient : {$hash}"
        ]);
        return Command::SUCCESS;
    }
}
