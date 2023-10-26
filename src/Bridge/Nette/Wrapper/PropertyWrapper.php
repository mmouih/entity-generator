<?php

namespace EntityGenerator\Bridge\Nette\Wrapper;

use Nette\PhpGenerator\Property;
use EntityGenerator\Bridge\Nette\Wrapper\Trait\NameTrait;
use EntityGenerator\Bridge\Nette\Wrapper\Trait\CommentTrait;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class PropertyWrapper
{
    use CommentTrait;
    use NameTrait;

    private Property $inner;

    public function __construct(string $name)
    {
        $this->inner = new Property($name);
    }

    public function getInner(): Property
    {
        return $this->inner;
    }

    public function setPublic(): void
    {
        $this->inner->setPublic();
    }

    public function setPrivate(): void
    {
        $this->inner->setPrivate();
    }

    public function setNullable(bool $state): void
    {
        $this->inner->setNullable($state);
    }

    public function setType(string $type): void
    {
        $this->inner->setType($type);
    }

    public function setValue(mixed $value): void
    {
        $this->inner->setValue($value);
    }
}
