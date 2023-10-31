<?php

namespace App\Tests\Feature;

use EntityGenerator\Tests\KernelTestCase;
use EntityGenerator\Handler\SchemaResolver;
use EntityGenerator\Type\SchemaDefinition;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class SchemaResolverTest extends KernelTestCase
{
    private SchemaResolver $resolver;

    public function setUp(): void
    {
        parent::setUp();
        $this->resolver = $this->container()->get(SchemaResolver::class);
    }
    public function testSimpleResolver(): void
    {
        $schema = $this->resolver->resolve(["id" => 2, "name" => "john doe"]);
        $this->assertCount(2, $schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertArrayHasKey('name', $schema);
        $this->assertInstanceOf(SchemaDefinition::class, $schema['id']);
        $this->assertEmpty($schema['id']->getSchema());
        $this->assertFalse($schema['id']->hasSchema());
        $this->assertEquals('int', $schema['id']->type);
        $this->assertEquals('string', $schema['name']->type);
    }

    public function testComplexResolver(): void
    {
        $schema = $this->resolver->resolve([
            "id" => 2,
            "name" => "john doe",
            "account" => ['account_id' => 1, 'label' => null],
            'details' => [
                ['uid' => 'ccsf', 'sample' => 'hello'],
                ['uid' => 'cfsx', 'sample' => null],
            ]
        ]);

        $this->assertCount(4, $schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertArrayHasKey('name', $schema);
        $this->assertArrayHasKey('account', $schema);
        $this->assertArrayHasKey('details', $schema);

        // All definitions must be a SchemaDefinition instances
        $this->assertContainsOnlyInstancesOf(SchemaDefinition::class, $schema);
        $this->assertEmpty($schema['id']->getSchema());
        $this->assertFalse($schema['id']->hasSchema());
        $this->assertEquals('int', $schema['id']->type);

        // test if it has complexe schema, and check field type
        $this->assertEmpty($schema['name']->getSchema());
        $this->assertFalse($schema['name']->hasSchema());
        $this->assertEquals('string', $schema['name']->type);

        $this->assertNotEmpty($schema['account']->getSchema());
        $this->assertTrue($schema['account']->hasSchema());
        $this->assertEquals('object', $schema['account']->type);

        // We do the same for child fields
        $accountSchema = $schema['account']->getSchema();
        $this->assertCount(2, $accountSchema);
        $this->assertArrayHasKey('account_id', $accountSchema);
        $this->assertArrayHasKey('label', $accountSchema);

        $this->assertEmpty($accountSchema['label']->getSchema());
        $this->assertFalse($accountSchema['label']->hasSchema());
        $this->assertEquals('null', $accountSchema['label']->type);

        $this->assertNotEmpty($schema['details']->getSchema());
        $this->assertTrue($schema['details']->hasSchema());
        $this->assertEquals('iterable', $schema['details']->type);
        $detailsSchema = $schema['details']->getSchema();

        $this->assertEmpty($detailsSchema['uid']->getSchema());
        $this->assertFalse($detailsSchema['uid']->hasSchema());
        $this->assertEquals('string', $detailsSchema['uid']->type);

        $this->assertEmpty($detailsSchema['sample']->getSchema());
        $this->assertFalse($detailsSchema['sample']->hasSchema());
        $this->assertEquals('string|null', $detailsSchema['sample']->type);
    }

    public function testCollectionPayload(): void
    {
        $schema = $this->resolver->resolve([["id" => 2, "name" => "john doe"], ["id" => 1, "name" => null]]);
        $this->assertArrayHasKey('id', $schema);
        $this->assertArrayHasKey('name', $schema);
        $this->assertInstanceOf(SchemaDefinition::class, $schema['id']);
        $this->assertEmpty($schema['id']->getSchema());
        $this->assertFalse($schema['id']->hasSchema());
        $this->assertEquals('int', $schema['id']->type);
        $this->assertEquals('string|null', $schema['name']->type);
    }
}
