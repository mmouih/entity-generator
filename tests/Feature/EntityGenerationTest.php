<?php

namespace App\Tests\Feature;

use EntityGenerator\Tests\KernelTestCase;
use EntityGenerator\Type\ConfigurationType;
use EntityGenerator\Handler\GenerationProcess;
use EntityGenerator\Bridge\Symfony\ParameterBagInterface;
use EntityGenerator\Exception\InvalidArgumentException;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class EntityGenerationTest extends KernelTestCase
{
    public function testGenerate(): void
    {
        $generationProcess = $this->container()->get(GenerationProcess::class);
        $files = $generationProcess->handle(new ConfigurationType(
            className: 'User',
            payload: __DIR__ . '/../data/user.json',
            file: true,
            format: 'json',
        ));

        $this->assertCount(6, $files);

        $outputDir = $this->container()->get(ParameterBagInterface::class)->get('output.dir');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Detail.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Contact.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Address.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Product.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Order.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'User.php');

        // clean up created files
        foreach ($files as $file) {
            unlink($file);
        }
    }
    public function testGenerateYaml(): void
    {
        $generationProcess = $this->container()->get(GenerationProcess::class);
        $files = $generationProcess->handle(new ConfigurationType(
            className: 'User',
            payload: __DIR__ . '/../data/user.yaml',
            file: true,
            format: 'yaml',
        ));

        $this->assertCount(6, $files);

        $outputDir = $this->container()->get(ParameterBagInterface::class)->get('output.dir');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Detail.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Contact.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Address.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Product.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Order.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'User.php');

        // clean up created files
        foreach ($files as $file) {
            unlink($file);
        }
    }
    public function testGenerateXml(): void
    {
        $generationProcess = $this->container()->get(GenerationProcess::class);
        $files = $generationProcess->handle(new ConfigurationType(
            className: 'User',
            payload: __DIR__ . '/../data/user.xml',
            file: true,
            format: 'xml',
        ));

        $this->assertCount(6, $files);

        $outputDir = $this->container()->get(ParameterBagInterface::class)->get('output.dir');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Detail.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Contact.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Address.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Products.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'Order.php');
        $this->assertFileExists($outputDir . DIRECTORY_SEPARATOR . 'User.php');

        // clean up created files
        foreach ($files as $file) {
            unlink($file);
        }
    }

    public function testGenerateFromInput(): void
    {
        $generationProcess = $this->container()->get(GenerationProcess::class);
        $files = $generationProcess->handle(new ConfigurationType(
            className : 'User',
            payload : json_encode([
                "id" => 2,
                "name" => "john doe",
                "account" => ['account_id' => 1, 'label' => null],
                'details' => [
                    ['uid' => 'ccsf', 'sample' => 'hello'],
                    ['uid' => 'cfsx', 'sample' => null],
                ]
            ]),
            file : false,
            format : 'json',
        ));

        $this->assertCount(3, $files);
        $detailFile = $this->container()->get(ParameterBagInterface::class)->get('output.dir') . DIRECTORY_SEPARATOR . 'Detail.php';
        $this->assertFileExists($detailFile);
        $expected = <<<EOF
<?php

namespace Entity\Generated;

/**
 * Autogenerated Entity
 */
class Detail
{
    /** @var string */
    public string \$uid;

    /** @var string|null */
    public ?string \$sample;
}

EOF;
        $this->assertEquals($expected, file_get_contents($detailFile));

        // Test account file for nullable types
        $accountFile = $this->container()->get(ParameterBagInterface::class)->get('output.dir') . DIRECTORY_SEPARATOR . 'Account.php';
        $this->assertFileExists($accountFile);
        $expected = <<<EOF
<?php

namespace Entity\Generated;

/**
 * Autogenerated Entity
 */
class Account
{
    /** @var int */
    public int \$accountId;

    /** @var null */
    public mixed \$label;
}

EOF;
        $this->assertEquals($expected, file_get_contents($accountFile));
        // clean up created files
        foreach ($files as $file) {
            unlink($file);
        }
    }

    public function testFileNotExist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $generationProcess = $this->container()->get(GenerationProcess::class);
        $generationProcess->handle(new ConfigurationType(
            className : 'User',
            payload: __DIR__ . '/../data/user1.cson',
            file: true,
            format: 'json',
        ));
    }
}
