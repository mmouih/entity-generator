<?php

namespace EntityGenerator\Exception;

class InvalidArgumentException extends GeneratorException
{
    public function __construct(string $message = "Invalid argument provided", int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
