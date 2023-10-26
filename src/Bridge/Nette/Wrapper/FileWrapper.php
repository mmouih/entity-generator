<?php

namespace EntityGenerator\Bridge\Nette\Wrapper;

use Nette\PhpGenerator\PhpFile;
use EntityGenerator\Bridge\Nette\Wrapper\NamespaceWrapper;
use EntityGenerator\Bridge\Nette\Wrapper\Trait\CommentTrait;
use EntityGenerator\Bridge\Nette\Wrapper\Trait\AddClassTrait;

class FileWrapper
{
    use CommentTrait;
    use AddClassTrait;

    private PhpFile $inner;
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
}
