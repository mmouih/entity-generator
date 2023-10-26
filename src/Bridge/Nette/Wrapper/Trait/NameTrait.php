<?php

namespace EntityGenerator\Bridge\Nette\Wrapper\Trait;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
trait NameTrait
{
    public function getName(): string
    {
        return $this->inner->getName();
    }
}
