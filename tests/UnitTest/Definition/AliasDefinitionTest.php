<?php

namespace DI\Test\UnitTest\Definition;

use DI\Definition\AliasDefinition;
use DI\Definition\CacheableDefinition;
use DI\Scope;
use EasyMock\EasyMock;
use Interop\Container\ContainerInterface;

/**
 * @covers \DI\Definition\AliasDefinition
 */
class AliasDefinitionTest extends \PHPUnit_Framework_TestCase
{
    use EasyMock;

    /**
     * @test
     */
    public function should_have_a_name()
    {
        $definition = new AliasDefinition('foo', 'bar');

        $this->assertEquals('foo', $definition->getName());
    }

    /**
     * @test
     */
    public function should_have_a_target_entry_name()
    {
        $definition = new AliasDefinition('foo', 'bar');

        $this->assertEquals('bar', $definition->getTargetEntryName());
    }

    /**
     * @test
     */
    public function should_have_prototype_scope()
    {
        $definition = new AliasDefinition('foo', 'bar');

        $this->assertEquals(Scope::PROTOTYPE, $definition->getScope());
    }

    /**
     * @test
     */
    public function should_be_cacheable()
    {
        $this->assertInstanceOf(CacheableDefinition::class, new AliasDefinition('foo', 'bar'));
    }

    /**
     * @test
     */
    public function should_resolve()
    {
        $container = $this->easySpy(ContainerInterface::class, [
            'get' => 42,
        ]);

        $definition = new AliasDefinition('foo', 'bar');

        $this->assertEquals(42, $definition->resolve($container));
    }

    /**
     * @test
     */
    public function should_be_resolvable()
    {
        $container = $this->easySpy(ContainerInterface::class, [
            'has' => true,
        ]);

        $definition = new AliasDefinition('foo', 'bar');

        $this->assertTrue($definition->isResolvable($container));
    }

    /**
     * @test
     */
    public function should_cast_to_string()
    {
        $this->assertEquals('get(bar)', (string) new AliasDefinition('', 'bar'));
    }
}
