<?php

namespace EntityGenerator\Type;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
interface TypeInterface
{
    public static function fromData(array $data): self;
}
