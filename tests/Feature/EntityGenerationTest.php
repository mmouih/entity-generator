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
            'payload' => __DIR__ . '/../data/user.json',
            'type' => 'json'
        ]));

        $this->assertCount(6, $files);
    }
}
