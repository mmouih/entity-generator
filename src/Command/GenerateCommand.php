<?php

declare(strict_types=1);

namespace EntityGenerator\Command;

use Throwable;
use EntityGenerator\Type\ConfigurationType;
use EntityGenerator\Handler\GenerationProcess;
use Symfony\Component\Console\Command\Command;
use EntityGenerator\Bridge\Symfony\ParameterBagInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use EntityGenerator\Exception\InvalidArgumentException;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
#[AsCommand(name: 'generate')]
class GenerateCommand extends Command
{
    public function __construct(
        private readonly GenerationProcess $classGenerationHandler,
        private readonly YamlEncoder $yamlEncoder,
        private readonly ParameterBagInterface $parameterBag
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Entity Generation');
        $io = new SymfonyStyle($input, $output);

        try {
            if (false === @file_get_contents($input->getOption('config'))) {
                throw new InvalidArgumentException(sprintf('configuration file %s not found or invalid', $input->getOption('config')));
            }

            $this->parameterBag->add(
                $this->yamlEncoder->decode(
                    file_get_contents($input->getOption('config')) ?: '',
                    'yaml'
                )
            );

            $printed = $this->classGenerationHandler->handle(new ConfigurationType(
                className: $input->getArgument('className'),
                payload: $input->getArgument('payload'),
                format: $input->getArgument('format'),
                file: $input->getOption('file'),
            ));

            $io->success('Entities generated with success in:');
            $io->info($printed);
        } catch (Throwable $excepetion) {
            $io->getErrorStyle()->error('An error has occured while generating entities:');
            $io->getErrorStyle()->warning([
                'message' => $excepetion->getMessage(),
                'file' => $excepetion->getFile() . ' on line ' . $excepetion->getLine()
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
            ->addOption('config', 'c', InputOption::VALUE_OPTIONAL, 'Is the payload a file ?', './config.yaml.dist')
            ->setHelp('Generate php a model from a payload');
    }
}
