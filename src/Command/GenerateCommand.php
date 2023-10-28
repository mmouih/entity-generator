<?php

declare(strict_types=1);

namespace EntityGenerator\Command;

use EntityGenerator\Type\GenerateCommandArgs;
use EntityGenerator\Handler\GenerationProcess;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
#[AsCommand(name: 'generate')]
class GenerateCommand extends Command
{
    public function __construct(private GenerationProcess $classGenerationHandler)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('start generating');
        $io = new SymfonyStyle($input, $output);

        try {
            $printed = $this->classGenerationHandler->handle(new GenerateCommandArgs(
                className: $input->getArgument('className'),
                payload: $input->getArgument('payload'),
                format: $input->getArgument('format'),
                file: $input->getOption('file')
            ));
            $io->success('Entities generated with success in:');
            $io->info($printed);
        } catch (\Throwable $excepetion) {
            $io->getErrorStyle()->error('An error has occured while generating entities:');
            $io->getErrorStyle()->info([
                'message' => $excepetion->getMessage(),
                'file' => $excepetion->getFile() . 'on line ' . $excepetion->getLine()
            ]);

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('className', InputArgument::REQUIRED, 'class name to generate')
            ->addArgument('payload', InputArgument::REQUIRED, 'payload')
            ->addArgument('format', InputArgument::OPTIONAL, 'payload format, json, xml, yaml', 'json')
            ->addOption('file', 'f', InputOption::VALUE_NONE, 'Is the payload a file ?')
            ->setHelp('Generate php a model from a payload');
    }
}
