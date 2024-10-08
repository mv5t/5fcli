<?php

namespace ToolCli\Context\Demo\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressIndicator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'demo:choice',
    description: 'Demo choice command',
    aliases:['d:c'],
    hidden: false
)]
class DemoChoiceCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $ready = $io->confirm('Vous etes pret ???');
        if (!$ready) {
            $output->writeln('<error>Revenez quand vous serrez pret !</error>');
            return Command::FAILURE;
        }
        $choice1 = $io->choice('Que voulez vous faire', ['rien', 'pas grand chose', 'Continuer'], 'Continuer');
        $io->note([
            'Lorem ipsum dolor sit amet',
            'Consectetur adipiscing elit',
            'Aenean sit amet arcu vitae sem faucibus porta',
        ]);
        // consider using arrays when displaying long caution messages
        $io->caution([
            'Lorem ipsum dolor sit amet',
            'Consectetur adipiscing elit',
            'Aenean sit amet arcu vitae sem faucibus porta',
        ]);

        // creates a new progress indicator
        $progressIndicator = new ProgressIndicator($output, 'verbose', 100, ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇']);

// starts and displays the progress indicator with a custom message
        $progressIndicator->start('Processing...');

        $i = 0;
        while ($i++ < 10) {
            // ... do some work
            sleep(1);
            // advances the progress indicator
            $progressIndicator->advance();
        }

// ensures that the progress indicator shows a final message
        $progressIndicator->finish('Finished');

        return Command::SUCCESS;
    }
}
