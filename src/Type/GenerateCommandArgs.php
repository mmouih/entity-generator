<?php

declare(strict_types=1);

namespace EntityGenerator\Type;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class GenerateCommandArgs implements TypeInterface
{
    public string $className;
    public ?string $payload;
    public ?string $file;
    public string $format = 'json';

    /**
     * @param array<string> $arguments
     * @return self
     */
    public static function fromData(array $arguments): self
    {
        $arg = new self();
        $arg->className = $arguments['className'];
        $arg->payload = $arguments['payload'];
        $arg->file = $arguments['file'];
        $arg->format = $arguments['format'];

        return $arg;
    }
}
