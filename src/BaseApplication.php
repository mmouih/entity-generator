<?php

declare(strict_types=1);

namespace PayloadEntityGenerator;

use Symfony\Component\Console\Application;

/**
* @author Mounir Mouih <mounir.mouih@gmail.com>
*/
final class BaseApplication extends Application
{
    public function __construct(iterable $commands = [])
    {
        parent::__construct();

        foreach ($commands as $command) {
            $this->add($command);
        }
    }
}
