<?php

namespace EntityGenerator\Bridge\Nette\Wrapper\Trait;

trait NameTrait
{
    public function getName(): string
    {
        return $this->inner->getName();
    }
}
