<?php

namespace App\Tests\Feature;

use PHPUnit\Framework\TestCase;
use EntityGenerator\Type\GenerateCommandArgs;
use EntityGenerator\Handler\GenerationProcess;

class EntityGenerationTest extends TestCase
{
    public function testGenerate(): void
    {
        require_once(__DIR__ . '/../bootstrap.php');

        $generationProcess = $container->get(GenerationProcess::class);
        $files = $generationProcess->handle(GenerateCommandArgs::fromData([
            'className' => 'User',
            'payload' => __DIR__ . '/../data/user.json',
            'type' => 'json'
        ]));

        $this->assertCount(6, $files);
    }
}