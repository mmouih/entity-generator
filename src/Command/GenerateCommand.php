<?php

declare(strict_types=1);

namespace PayloadEntityGenerator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use PayloadEntityGenerator\Handler\ClassGenerationProcessHandler;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'generate')]
class GenerateCommand extends Command
{
    public function __construct(private ClassGenerationProcessHandler $classGenerationHandler)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('start generating');
        $this->classGenerationHandler->handle([
            'payload' => $input->getArgument('payload'),
            'type' => $input->getArgument('type')
        ]);
        $output->writeln('file generated with success');

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('payload', InputArgument::REQUIRED, 'payload or file')
            ->addArgument('type', InputArgument::OPTIONAL, 'payload type, xml or file', 'json')
            ->setHelp('Generate php a model from a payload');
    }
}
