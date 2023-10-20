<?php

namespace PayloadEntityGenerator\Handler;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\FileSystem;
use Nette\PhpGenerator\PsrPrinter;

class EntityPrinter
{
    public function __construct(
        private FileSystem $fileSystem,
        private PsrPrinter $printer,
        private array $parameters
    ) {
    }

    public function print(string $filename, PhpFile $file): void
    {
        $this->fileSystem->write(
            $this->parameters['print_dir'] . DIRECTORY_SEPARATOR . $filename,
            $this->printer->printFile($file)
        );
    }
}
