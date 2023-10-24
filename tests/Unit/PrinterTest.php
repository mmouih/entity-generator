<?php

namespace App\Tests\Feature;

use EntityGenerator\Handler\Printer;
use EntityGenerator\Tests\KernelTestCase;
use Nette\PhpGenerator\PhpFile;

class PrinterTest extends KernelTestCase
{
    private Printer $printer;

    public function setUp(): void
    {
        parent::setUp();
        $this->printer = $this->container()->get(Printer::class);
    }
    public function testPrinter(): void
    {
        $file = new PhpFile();
        $file->addComment("this is a comment in a php file");
        $file->addClass('JaneDoeEmulator');
        $path = $this->printer->print("test.php", $file);
        $expected = <<<EOF
<?php

/**
 * this is a comment in a php file
 */

class JaneDoeEmulator
{
}

EOF;
        $this->assertEquals($expected, file_get_contents($path));
        // clean printed file
        unlink($path);
    }
}
