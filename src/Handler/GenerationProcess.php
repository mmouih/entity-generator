<?php

declare(strict_types=1);

namespace EntityGenerator\Handler;

use stdClass;
use Nette\PhpGenerator\PhpFile;
use EntityGenerator\Type\GenerateCommandArgs;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class GenerationProcess
{
    public function __construct(
        private JsonDecode $decoder,
        private SchemaResolver $schemaResolver,
        private EntityGenerator $entityGenerator,
        private Printer $printer,
    ) {
    }

    /**
     * @return array<string> List of printed files
     */
    public function handle(GenerateCommandArgs $argument): array
    {
        $schema = $this->schemaResolver->resolve(
            (array) $this->decode(file_get_contents($argument->payload) ?: '', $argument->type)
        );

        $phpFiles = $this->entityGenerator->generate($argument->className, $schema);

        $printed = [];
        foreach ($phpFiles as $generatedClassName => $phpFile) {
            $printed[] = $this->printer->print($generatedClassName . '.php', $phpFile);
        }

        return $printed;
    }

    private function decode(string $payload, string $type): mixed
    {
        return $this->decoder->decode($payload, $type);
    }
}
