<?php

namespace EntityGenerator\Bridge\Nette\Wrapper\Trait;

use EntityGenerator\Bridge\Nette\Wrapper\ClassWrapper;

trait AddClassTrait
{
    public function addClass(string $class): ClassWrapper
    {
        $classWrapper = new ClassWrapper($class);
        $this->inner->addClass($class);

        return $classWrapper;
    }
}
