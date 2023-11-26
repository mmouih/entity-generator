<?php

namespace EntityGenerator\Bridge\Nette\Wrapper;

use Nette\PhpGenerator\PhpFile;
use EntityGenerator\Bridge\Nette\Wrapper\Trait\CommentTrait;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class FileWrapper
{
    use CommentTrait;

    private readonly PhpFile $inner;
    public function __construct()
    {
        $this->inner = new PhpFile();
    }

    public function addNamespace(NamespaceWrapper $namespace): self
    {
        $this->inner->addNamespace($namespace->getInner());
        return $this;
    }

    public function getInner(): PhpFile
    {
        return $this->inner;
    }

    public function addClass(string $class): ClassWrapper
    {
        $classWrapper = new ClassWrapper($class);
        $this->inner->addClass($class);

        return $classWrapper;
    }
}
