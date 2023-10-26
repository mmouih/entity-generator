<?php

namespace EntityGenerator\Bridge\Nette\Wrapper;

use Nette\PhpGenerator\ClassType;
use EntityGenerator\Bridge\Nette\Wrapper\Trait\CommentTrait;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class ClassWrapper
{
    use CommentTrait;

    private ClassType $inner;

    public function __construct(string|ClassType $className)
    {
        if ($className instanceof ClassType) {
            $this->inner = $className;
        } else {
            $this->inner = new ClassType($className);
        }
    }

    public function addMember(PropertyWrapper $member): void
    {
        $this->inner->addMember($member->getInner());
    }

    public function getInner(): ClassType
    {
        return $this->inner;
    }
}
