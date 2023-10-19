<?php

namespace PayloadEntityGenerator\Handler;

interface HandlerInterface
{
    public function handle(array $data): void;
}
