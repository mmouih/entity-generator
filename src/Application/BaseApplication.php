<?php

declare(strict_types=1);

namespace PayloadEntityGenerator\Application;

use Symfony\Component\Console\Application;

final class BaseApplication extends Application
{
    public function __construct(iterable $commands = [])
    {
        parent::__construct();

        $commands = $commands instanceof \Traversable ? \iterator_to_array($commands) : $commands;
        foreach ($commands as $command) {
            $this->add($command);
        }
    }
}
