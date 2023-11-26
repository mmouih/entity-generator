<?php

declare(strict_types=1);

namespace EntityGenerator\Type;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class SchemaDefinition
{
    /**
     * @var ?array<self>
     */
    private ?array $schema = null;
    public string $type;

    /**
     * @param array<mixed> $data
     */
    public static function fromData(array $data): self
    {
        $arg = new self();
        $arg->schema = $data['schema'] ?? null;
        $arg->type = $data['type'];

        return $arg;
    }

    public function isNullable(): bool
    {
        return str_contains($this->type, 'null') || str_contains($this->type, '?');
    }

    public function isIterable(): bool
    {
        return $this->type === 'iterable';
    }

    public function hasSchema(): bool
    {
        return null !== $this->schema;
    }

    /**
     * @return array<self>
     */
    public function getSchema(): array
    {
        return $this->schema ?? [];
    }
}
