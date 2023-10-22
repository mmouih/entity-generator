<?php

declare(strict_types=1);

namespace EntityGenerator\Handler;

use EntityGenerator\Type\GenerateCommandArgs;
use stdClass;
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

    public function handle(GenerateCommandArgs $argument): void
    {
        $schema = $this->schemaResolver->resolve(
            (array) $this->decode(file_get_contents($argument->payload) ?: '', $argument->type)
        );

        $phpFiles = $this->entityGenerator->generate($argument->className, $schema);

        foreach ($phpFiles as $generatedClassName => $phpFile) {
            $this->printer->print($generatedClassName . '.php', $phpFile);
        }
    }

    private function decode(string $payload, string $type): mixed
    {
        return $this->decoder->decode($payload, $type);
    }
}
