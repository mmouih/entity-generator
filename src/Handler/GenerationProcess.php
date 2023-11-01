<?php

declare(strict_types=1);

namespace EntityGenerator\Handler;

use EntityGenerator\Bridge\Nette\Printer;
use EntityGenerator\Bridge\Symfony\ParameterBag;
use EntityGenerator\Type\ConfigurationType;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class GenerationProcess
{
    public function __construct(
        private Decoder $decoder,
        private SchemaResolver $schemaResolver,
        private EntityGenerator $entityGenerator,
        private Printer $printer,
        private ParameterBag $parameterBag
    ) {
    }

    /**
     * @return array<string> List of printed files
     */
    public function handle(ConfigurationType $argument): array
    {
        $schema = $this->schemaResolver->resolve(
            $this->decoder->decode($argument)
        );

        $files = $this->entityGenerator->generate(
            $this->parameterBag->get('namespace'),
            $argument->getClassName(),
            $schema
        );

        $printed = [];
        foreach ($files as $generatedClassName => $file) {
            $printed[] = $this->printer->print(
                $this->parameterBag->get('output.dir'),
                $generatedClassName . '.php',
                $file
            );
        }

        return $printed;
    }
}
