<?php

namespace EntityGenerator\Type;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class GenerateCommandArgs implements TypeInterface
{
    public string $className;
    public string $payload;
    public string $type;

    public static function fromData(array $arguments): self
    {
        $arg = new self();
        $arg->className = $arguments['className'];
        $arg->payload = $arguments['payload'];
        $arg->type = $arguments['type'];

        return $arg;
    }
}