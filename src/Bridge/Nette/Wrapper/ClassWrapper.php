<?php

namespace EntityGenerator\Bridge\Nette\Wrapper;

use Nette\PhpGenerator\ClassType;
use EntityGenerator\Bridge\Nette\Wrapper\Trait\CommentTrait;

class ClassWrapper
{
    use CommentTrait;

    private ClassType $inner;

    public function __construct(string $className)
    {
        $this->inner = new ClassType($className);
    }

    public function addMember(PropertyWrapper $member): void
    {
        $this->inner->addMember($member->getInner());
    }
}
