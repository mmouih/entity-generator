<?php

namespace App\Tests\Feature;

use EntityGenerator\Type\GenerateCommandArgs;
use EntityGenerator\Handler\GenerationProcess;
use EntityGenerator\Tests\KernelTestCase;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class EntityGenerationTest extends KernelTestCase
{
    public function testGenerate(): void
    {
        $generationProcess = $this->container()->get(GenerationProcess::class);
        $files = $generationProcess->handle(GenerateCommandArgs::fromData([
            'className' => 'User',
            'payload' => __DIR__ . '/../data/user.json',
            'source' => 'file',
            'format' => 'json',
        ]));

        $this->assertCount(6, $files);
        // clean up created files
        foreach ($files as $file) {
            unlink($file);
        }
    }

    public function testGenerateFromInput(): void
    {
        $generationProcess = $this->container()->get(GenerationProcess::class);
        $files = $generationProcess->handle(GenerateCommandArgs::fromData([
            'className' => 'User',
            'payload' => json_encode([
                "id" => 2,
                "name" => "john doe",
                "account" => ['account_id' => 1, 'label' => null],
                'details' => [
                    ['uid' => 'ccsf', 'sample' => 'hello'],
                    ['uid' => 'cfsx', 'sample' => null],
                ]
            ]),
            'source' => 'text',
            'format' => 'json',
        ]));

        $this->assertCount(3, $files);
        // clean up created files
        foreach ($files as $file) {
            unlink($file);
        }
    }

    public function testFileNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $generationProcess = $this->container()->get(GenerationProcess::class);
        $generationProcess->handle(GenerateCommandArgs::fromData([
            'className' => 'User',
            'payload' => __DIR__ . '/../data/user1.cson',
            'source' => 'file',
            'format' => 'json',
        ]));
    }
}
