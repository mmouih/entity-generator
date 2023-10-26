<?php // phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols, waiting for v8.2 readonly bug fix

declare(strict_types=1);

namespace EntityGenerator\Type;

use EntityGenerator\Bridge\Nette\Wrapper\NamespaceWrapper;
use EntityGenerator\Bridge\Nette\Wrapper\PropertyWrapper;

readonly class PropertyMetaData
{
    public function __construct(
        public PropertyWrapper $property,
        public SchemaDefinition $definition,
        public NamespaceWrapper $namespace
    ) {
    }
}
