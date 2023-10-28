<?php

declare(strict_types=1);

namespace EntityGenerator\Handler;

use EntityGenerator\Bridge\Nette\Printer;
use EntityGenerator\Type\GenerateCommandArgs;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class GenerationProcess
{
    /**
     * @param string[] $parameters
     */
    public function __construct(
        private Decoder $decoder,
        private SchemaResolver $schemaResolver,
        private EntityGenerator $entityGenerator,
        private Printer $printer,
        private array $parameters
    ) {
    }

    /**
     * @return array<string> List of printed files
     */
    public function handle(GenerateCommandArgs $argument): array
    {
        $schema = $this->schemaResolver->resolve(
            $this->decoder->decode($argument)
        );

        $files = $this->entityGenerator->generate($argument->getClassName(), $schema);

        $printed = [];
        foreach ($files as $generatedClassName => $file) {
            $printed[] = $this->printer->print(
                $this->parameters['print_dir'],
                $generatedClassName . '.php',
                $file
            );
        }

        return $printed;
    }
}
