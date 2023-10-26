<?php

namespace EntityGenerator\Bridge\Nette\Wrapper;

use Nette\PhpGenerator\PhpNamespace;
use EntityGenerator\Bridge\Nette\Wrapper\Trait\NameTrait;
use EntityGenerator\Bridge\Nette\Wrapper\Trait\AddClassTrait;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class NamespaceWrapper
{
    use NameTrait;

    private PhpNamespace $inner;

    public function __construct(string $name)
    {
        $this->inner = new PhpNamespace($name);
    }

    public function getInner(): PhpNamespace
    {
        return $this->inner;
    }

    public function addClass(string $class): ClassWrapper
    {
        return new ClassWrapper($this->inner->addClass($class));
    }
}
