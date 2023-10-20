<?php

namespace EntityGenerator\Handler;

/**
 * Generates a Schema from data
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class SchemaResolver
{
    public function resolve(\stdClass|array $data): array
    {
        $structure = [];
        foreach ($data as $field => $value) {
            if (is_scalar($value)) {
                $structure[$field] = ['type' => $this->getScalarType($value), 'schema' => null];
            } elseif (is_object($value)) {
                // fetch the structure again
                $structure[$field] = ['type' => 'object', 'schema' => $this->resolve($value)];
            } else {
                // we only consider the structure of the first element of a collection
                $structure[$field] = ['type' => 'iterable', 'schema' => $this->resolve(current($value))];
            }
        }

        return $structure;
    }

    private function getScalarType(string $value): string
    {
        // todo detect nullable items from payload!, for now all variable are considered nullable
        $type = gettype($value);

        return '?' . $type;
    }
}
