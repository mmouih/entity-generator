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
     * @return array<SchemaDefinition>
     */
    public function resolve(\stdClass|array $data): array
    {
        $schema = [];
        foreach ($data as $field => $value) {
            if (is_scalar($value) || is_null($value)) {
                $definition = ['type' => $this->getScalarType($value)];
            } elseif (is_object($value)) {
                // fetch the schema again
                $definition = ['type' => 'object', 'schema' => $this->resolve($value)];
            } elseif (is_iterable($value)) {
                // we only consider the schema of the first element of a collection
                $definition = ['type' => 'iterable', 'schema' => $this->resolveCollection($value)];
            } else {
                throw new \LogicException('payload values can be either scalar, iterabel or stdClass objects !');
            }

            $schema[$field] = SchemaDefinition::fromData($definition);
        }

        return $schema;
    }

    /**
     * Resolve collection schema, we join the types and object schema if provided
     */
    private function resolveCollection(\stdClass|array $collection): array
    {
        $typesPerField = [];
        foreach ($collection as $value) {
            $resolved = $this->resolve($value);
            foreach ($resolved as $field => $schemaDefition) {
                // handle types join
                if (!in_array($schemaDefition->type, $typesPerField[$field]['types'] ?? [])) {
                    $typesPerField[$field]['types'][] = $schemaDefition->type;
                }

                // handle schema join
                if (empty($typesPerField[$field]['schema'])) {
                    $typesPerField[$field]['schema'] = $schemaDefition->schema;
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
