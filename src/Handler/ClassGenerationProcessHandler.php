<?php

namespace PayloadEntityGenerator\Handler;

use stdClass;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ClassGenerationProcessHandler implements HandlerInterface
{
    public function __construct(private JsonDecode $decoder)
    {
    }

    public function handle(array $data): void
    {
        $decoded = $this->decode(file_get_contents($data['payload']), $data['type']);
        $structure = $this->getStructure($decoded);
        $this->generateClassFromArray($structure);
    }

    private function decode(string $payload, string $type): stdClass
    {
        return $this->decoder->decode($payload, $type);
    }

    private function generateClassFromArray(array $structure): void
    {
        // todo implement
    }

    private function getStructure(stdClass|array $decoded): array
    {
        $structure = [];
        foreach ($decoded as $field => $value) {
            if (is_scalar($value)) {
                $structure[$field] = ['type' => $this->getFieldType($value), 'schema' => null];
            } elseif (is_object($value)) {
                // fetch the structure again
                $structure[$field] = ['type' => 'object', 'schema' => $this->getStructure($value)];
            } else {
                // we only consider the structure of the first element of a collection
                $structure[$field] = ['type' => 'collection', 'schema' => $this->getStructure(current($value))];
            }
        }

        return $structure;
    }

    private function getFieldType(string $value): string
    {
        // todo implement method logic
        return 'string';
    }
}
