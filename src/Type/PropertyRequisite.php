<?php

namespace EntityGenerator\Type;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class PropertyRequisite
{
    public function __construct(
        public ClassType $class,
        public SchemaDefinition $definition,
        public PhpNamespace $namespace,
        public string $propertyName
    ) {
    }
}
