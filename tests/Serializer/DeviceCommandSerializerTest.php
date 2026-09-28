<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceCommand;
use ChristianBrown\SmartThings\Serializer\DeviceCommandSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceCommand::class)]
#[CoversClass(DeviceCommandSerializer::class)]
final class DeviceCommandSerializerTest extends TestCase
{
    public function testSerializeMultipleCommands(): void
    {
        $serializer = new DeviceCommandSerializer();

        $actual = $serializer->serialize([new DeviceCommand('switch', 'on'), new DeviceCommand('switch', 'off')]);

        self::assertCount(2, $actual);
        self::assertSame('on', $actual[0][DeviceCommandSerializerInterface::KEY_COMMAND]);
        self::assertSame('off', $actual[1][DeviceCommandSerializerInterface::KEY_COMMAND]);
    }

    public function testSerializeOmitsUnsetOptionals(): void
    {
        $command = new DeviceCommand('switch', 'on');

        $serializer = new DeviceCommandSerializer();

        $actual = $serializer->serialize([$command]);

        self::assertSame(
            [
                [
                    DeviceCommandSerializerInterface::KEY_CAPABILITY => 'switch',
                    DeviceCommandSerializerInterface::KEY_COMMAND => 'on',
                ],
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $command = (new DeviceCommand('switchLevel', 'setLevel'))
            ->setComponent('main')
            ->setCommandId('test-command-id')
            ->setArguments([80]);

        $serializer = new DeviceCommandSerializer();

        $actual = $serializer->serialize([$command]);

        self::assertSame(
            [
                [
                    DeviceCommandSerializerInterface::KEY_CAPABILITY => 'switchLevel',
                    DeviceCommandSerializerInterface::KEY_COMMAND => 'setLevel',
                    DeviceCommandSerializerInterface::KEY_COMPONENT => 'main',
                    DeviceCommandSerializerInterface::KEY_COMMAND_ID => 'test-command-id',
                    DeviceCommandSerializerInterface::KEY_ARGUMENTS => [80],
                ],
            ],
            $actual
        );
    }
}
