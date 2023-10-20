<?php

namespace EntityGenerator\Type;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
interface ArgumentObjectInterface
{
    public static function fromArguments(array $arguments): self;
}
