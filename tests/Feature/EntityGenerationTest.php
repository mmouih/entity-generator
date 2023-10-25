<?php

namespace App\Tests\Feature;

use EntityGenerator\Type\GenerateCommandArgs;
use EntityGenerator\Handler\GenerationProcess;
use EntityGenerator\Tests\KernelTestCase;

class EntityGenerationTest extends KernelTestCase
{
    public function testGenerate(): void
    {
        $generationProcess = $this->container()->get(GenerationProcess::class);
        $files = $generationProcess->handle(GenerateCommandArgs::fromData([
            'className' => 'User',
            'file' => __DIR__ . '/../data/user.json',
            'payload' => null,
            'format' => 'json',
        ]));

        $this->assertCount(6, $files);
        // clean up created files
        foreach ($files as $file) {
            unlink($file);
        }
    }
}
