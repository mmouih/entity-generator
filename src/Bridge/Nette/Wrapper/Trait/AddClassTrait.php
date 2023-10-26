<?php

namespace EntityGenerator\Bridge\Nette\Wrapper\Trait;

use EntityGenerator\Bridge\Nette\Wrapper\ClassWrapper;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
trait AddClassTrait
{
    public function addClass(string $class): ClassWrapper
    {
        $classWrapper = new ClassWrapper($class);
        $this->inner->addClass($class);

        return $classWrapper;
    }
}
