<?php

declare(strict_types=1);

namespace EntityGenerator\Handler;

use EntityGenerator\Bridge\Nette\Printer;
use EntityGenerator\Type\GenerateCommandArgs;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class GenerationProcess
{
    /**
     * @param string[] $parameters
     */
    public function __construct(
        private JsonDecode $decoder,
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
            $this->decode($argument)
        );

        $files = $this->entityGenerator->generate($argument->className, $schema);

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

    private function decode(GenerateCommandArgs $argument): mixed
    {
        if ($argument->isFile() && !file_exists($argument->payload)) {
            throw new \InvalidArgumentException(sprintf('File %s does not exit!', $argument->payload));
        }

        if ($argument->isFile()) {
            $content = file_get_contents($argument->payload) ?: '';
        } else {
            $content = $argument->payload ?: '{}';
        }

        return (array)$this->decoder->decode($content, $argument->format);
    }
}
