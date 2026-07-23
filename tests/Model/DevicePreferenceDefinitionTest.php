<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DevicePreferenceDefinition;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DevicePreferenceDefinition::class)]
final class DevicePreferenceDefinitionTest extends TestCase
{
    public function test(): void
    {
        $definition = new DevicePreferenceDefinition('test-preference-id');
        self::assertSame('test-preference-id', $definition->getPreferenceId());
        self::assertNull($definition->getDescription());
        self::assertNull($definition->getName());
        self::assertNull($definition->getPreferenceType());
        self::assertNull($definition->getRequired());
        self::assertNull($definition->getTitle());

        self::assertSame($definition, $definition->setPreferenceId('test-new-preference-id'));
        self::assertSame($definition, $definition->setDescription('Test description'));
        self::assertSame($definition, $definition->setName('tempOffset'));
        self::assertSame($definition, $definition->setPreferenceType('integer'));
        self::assertSame($definition, $definition->setRequired(true));
        self::assertSame($definition, $definition->setTitle('Temperature Offset'));

        self::assertSame('test-new-preference-id', $definition->getPreferenceId());
        self::assertSame('Test description', $definition->getDescription());
        self::assertSame('tempOffset', $definition->getName());
        self::assertSame('integer', $definition->getPreferenceType());
        self::assertTrue($definition->getRequired());
        self::assertSame('Temperature Offset', $definition->getTitle());
    }
}
