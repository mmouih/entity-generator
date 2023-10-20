<?php

namespace EntityGenerator\Handler;

use EntityGenerator\Type\GenerateCommandArgs;
use stdClass;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class EntityGenerationProcess
{
    public function __construct(
        private JsonDecode $decoder,
        private SchemaResolver $schemaResolver,
        private EntityGenerator $entityGenerator,
        private EntityPrinter $entityPrinter,
    ) {
    }

    public function handle(GenerateCommandArgs $argument): void
    {
        $schema = $this->schemaResolver->resolve(
            $this->decode(file_get_contents($argument->payload), $argument->type)
        );

        $phpFile = $this->entityGenerator->generate($argument->className, $schema);

        // todo: this action maybe recursive, for association
        $this->entityPrinter->print($argument->className . 'php', $phpFile);
    }

    private function decode(string $payload, string $type): stdClass
    {
        return $this->decoder->decode($payload, $type);
    }
}
