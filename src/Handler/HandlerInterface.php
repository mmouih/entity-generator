<?php

namespace PayloadEntityGenerator\Handler;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
interface HandlerInterface
{
    public function handle(array $data): void;
}
