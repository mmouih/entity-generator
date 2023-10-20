<?php // phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols, waiting for v8.2 readonly bug fix

declare(strict_types=1);

namespace EntityGenerator\Type;

use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Property;

readonly class PropertyMetadata
{
    public function __construct(
        public Property $property,
        public SchemaDefinition $definition,
        public PhpNamespace $namespace
    ) {
    }
}
