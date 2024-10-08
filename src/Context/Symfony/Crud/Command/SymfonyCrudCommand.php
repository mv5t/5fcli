<?php

declare(strict_types=1);

namespace ToolCli\Context\Symfony\Crud\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use ToolCli\Context\Symfony\Crud\Service\FileService;

#[AsCommand(
    name: 'symfony:crud',
    description: 'Create a CRUD',
    aliases:['s:c'],
    hidden: false
)]
class SymfonyCrudCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $io->ask('Quelle entité ?');
        if (FileService::createController($name) && FileService::createForm($name) && FileService::createTemplates($name)) {
            $io->success('Ok');
            return Command::SUCCESS;
        }
        $io->error('Erreur');
        return Command::FAILURE;
    }
}
