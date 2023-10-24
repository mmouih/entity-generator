<?php

namespace EntityGenerator\Handler;

use EntityGenerator\Type\SchemaDefinition;

/**
 * Generates a Schema from data
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class SchemaResolver
{
    /**
     * @param array<mixed> $data
     * @return array<SchemaDefinition>
     */
    public function resolve(array $data): array
    {
        $schema = [];
        foreach ($data as $field => $value) {
            $schema[$field] = SchemaDefinition::fromData(
                $this->resolveField($value)
            );
        }

        return $schema;
    }

    /**
     * @param mixed $value
     * @return  array<string, array<SchemaDefinition>|string>
     */
    private function resolveField(mixed $value): array
    {
        if (is_scalar($value) || is_null($value)) {
            return ['type' => $this->getScalarType($value)];
        }

        if (is_object($value)) {
            // fetch the schema recursively
            return ['type' => 'object', 'schema' => $this->resolve((array)$value)];
        }

        if (is_iterable($value)) {
            return ['type' => 'iterable', 'schema' => $this->resolveCollection($value)];
        }

        throw new \LogicException('payload values can be either scalar, iterable or stdClass objects !');
    }

    /**
     * Resolve collection schema, we join the types and object schema if provided
     * @param iterable<mixed> $collection
     * @return array<SchemaDefinition>
     */
    private function resolveCollection(iterable $collection): array
    {
        $typesPerField = [];
        foreach ($collection as $value) {
            $resolved = $this->resolve((array)$value);
            foreach ($resolved as $field => $schemaDefition) {
                // handle types join
                if (!in_array($schemaDefition->type, $typesPerField[$field]['types'] ?? [])) {
                    $typesPerField[$field]['types'][] = $schemaDefition->type;
                }

                // handle schema join
                if (empty($typesPerField[$field]['schema'])) {
                    // beware: creating a schema with value != null, an entity will be generated even if empty !
                    $typesPerField[$field]['schema'] = $schemaDefition->hasSchema() ? $schemaDefition->getSchema() : null;
                }
            }
        }

        $schema = [];
        foreach ($typesPerField as $field => $detail) {
            $schema[$field] = SchemaDefinition::fromData(['type' => implode('|', $detail['types']), 'schema' => $detail['schema']]);
        }

        return $schema;
    }

    private function getScalarType(mixed $value): string
    {
        return match (gettype($value)) {
            'integer' => 'int',
            'double' => 'float',
            'string' => 'string',
            'NULL' => 'null',
            'boolean' => 'bool',
            default => throw new \LogicException(),
        };
    }
}
