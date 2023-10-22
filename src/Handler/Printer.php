<?php

declare(strict_types=1);

namespace EntityGenerator\Handler;

use Nette\PhpGenerator\PhpFile;
use Nette\Utils\FileSystem;
use Nette\PhpGenerator\PsrPrinter;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class Printer
{
    /**
     * @param string[] $parameters
     */
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
