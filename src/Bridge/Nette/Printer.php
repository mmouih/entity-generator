<?php

declare(strict_types=1);

namespace EntityGenerator\Bridge\Nette;

use Nette\Utils\FileSystem;
use EntityGenerator\Bridge\Nette\Wrapper\FileWrapper;
use Nette\PhpGenerator\PsrPrinter;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class Printer
{
    public function __construct(
        private FileSystem $fileSystem,
        private PsrPrinter $printer
    ) {
    }

    public function print(string $directory, string $filename, FileWrapper $file): string
    {
        $path = $directory . DIRECTORY_SEPARATOR . $filename;
        $this->fileSystem->write(
            $path,
            $this->printer->printFile($file->getInner())
        );

        return $path;
    }
}
