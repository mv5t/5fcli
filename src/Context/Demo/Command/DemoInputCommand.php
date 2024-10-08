<?php

namespace ToolCli\Context\Demo\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'demo:input',
    description: 'Demo input command',
    aliases:['d:i'],
    hidden: false
)]
class DemoInputCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $prenom = $io->ask('Quel est votre prénom?');
        $age = $io->ask('Quel est votre age? (essayez des lettres)', 100, function (string $value) use ($io) {
            if (!is_numeric($value)) {
                throw new \RuntimeException('You must type a number.');
            }
            return (int) $value;
        });
        $hidden = $io->askHidden('Un mot secret ?');
        $io->success([
            "Bonjour {$prenom} vous avez {$age} ans! Votre",
            "Votre mot secret : {$hidden}"
        ]);
        return Command::SUCCESS;
    }
}
