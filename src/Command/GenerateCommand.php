<?php

declare(strict_types=1);

namespace EntityGenerator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use EntityGenerator\Handler\GenerationProcess;
use EntityGenerator\Type\GenerateCommandArgs;
use Symfony\Component\Console\Input\InputOption;
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
        try {
            $printed = $this->classGenerationHandler->handle(GenerateCommandArgs::fromData([
                'className' => $input->getArgument('className'),
                'payload' => $input->getArgument('payload'),
                'format' => $input->getArgument('format'),
                'source' => $input->getOption('source'),
            ]));
            $output->writeln('files generated with success in:');
            $output->writeln($printed);
        } catch (\Throwable $excepetion) {
            $output->writeln([
                'message' => 'An error has occured while generating files : ' . $excepetion->getMessage(),
                'file' => $excepetion->getFile(),
                'line' => $excepetion->getLine(),
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
            ->addArgument('format', InputArgument::OPTIONAL, 'payload format, xml or file', 'json')
            ->addOption('source', 'src', InputOption::VALUE_OPTIONAL, 'the payload used is it a file!', 'file')
            ->setHelp('Generate php a model from a payload');
    }
}
