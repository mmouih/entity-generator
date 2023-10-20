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
            if (is_scalar($value)) {
                $definition = ['type' => $this->getScalarType($value)];
            } elseif (is_object($value)) {
                // fetch the schema again
                $definition = ['type' => 'object', 'schema' => $this->resolve($value)];
            } else {
                // we only consider the schema of the first element of a collection
                $definition = ['type' => 'iterable', 'schema' => $this->resolve(current($value))];
            }

            $schema[$field] = SchemaDefinition::fromData($definition);
        }

        return $schema;
    }

    private function getScalarType(string $value): string
    {
        // todo detect nullable items from payload!, for now all variable are considered nullable
        $type = gettype($value);

        return '?' . $type;
    }
}
