<?php

namespace PayloadEntityGenerator\Handler;

use stdClass;
use Symfony\Component\Serializer\Encoder\JsonDecode;

class ClassGenerationProcessHandler implements HandlerInterface
{
    public function __construct(
        private JsonDecode $decoder,
        private SchemaResolver $schemaResolver,
        private EntityGenerator $entityGenerator,
        private EntityPrinter $entityPrinter,
    ) {
    }

    public function handle(array $data): void
    {
        $schema = $this->schemaResolver->resolve(
            $this->decode(file_get_contents($data['payload']), $data['type'])
        );

        $phpFile = $this->entityGenerator->generate($data['className'], $schema);

        // todo: this action maybe recursive, for association
        $this->entityPrinter->print($data['className'] . 'php', $phpFile);
    }

    private function decode(string $payload, string $type): stdClass
    {
        return $this->decoder->decode($payload, $type);
    }
}
