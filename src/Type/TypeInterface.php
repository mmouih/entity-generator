<?php

declare(strict_types=1);

namespace EntityGenerator\Type;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
interface TypeInterface
{
    /**
     * @param array<mixed> $data
     * @return self
     */
    public static function fromData(array $data): self;
}
