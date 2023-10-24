<?php

namespace App\Tests\Feature;

use EntityGenerator\Component\StringProcessor;
use EntityGenerator\Tests\KernelTestCase;

class StringProcessorTest extends KernelTestCase
{
    private StringProcessor $stringProcessor;

    public function setUp(): void
    {
        parent::setUp();
        $this->stringProcessor = $this->container()->get(StringProcessor::class);
    }
    public function testNormalizeClass(): void
    {
        $this->assertSame("User", $this->stringProcessor->normalizeClassName("user"));
        $this->assertSame("User", $this->stringProcessor->normalizeClassName("users", true));
        $this->assertSame("AccountDetail", $this->stringProcessor->normalizeClassName("account_detail"));
        $this->assertSame("AccountDetail", $this->stringProcessor->normalizeClassName("account_details", true));
    }

    public function testSingularize(): void
    {
        $this->assertSame("user", $this->stringProcessor->singularize("user"));
        $this->assertSame("user", $this->stringProcessor->singularize("users"));
        $this->assertSame("account_detail", $this->stringProcessor->singularize("account_detail"));
        $this->assertSame("account_detail", $this->stringProcessor->singularize("account_details"));
    }

    public function testCamelCase(): void
    {
        $this->assertSame("user", $this->stringProcessor->toCamelCase("USER"));
        $this->assertSame("userDetail", $this->stringProcessor->toCamelCase("USER_DETAIL"));
        $this->assertSame("daDa", $this->stringProcessor->toCamelCase("da-da"));
        $this->assertSame("johnDoe", $this->stringProcessor->toCamelCase("john_doe"));
    }
}
