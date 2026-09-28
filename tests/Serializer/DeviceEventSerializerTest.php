<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceEvent;
use ChristianBrown\SmartThings\Serializer\DeviceEventSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceEventSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceEvent::class)]
#[CoversClass(DeviceEventSerializer::class)]
final class DeviceEventSerializerTest extends TestCase
{
    public function testSerializeMultipleEvents(): void
    {
        $serializer = new DeviceEventSerializer();

        $actual = $serializer->serialize([new DeviceEvent('on'), new DeviceEvent('off')]);

        self::assertCount(2, $actual);
        self::assertSame('on', $actual[0][DeviceEventSerializerInterface::KEY_VALUE]);
        self::assertSame('off', $actual[1][DeviceEventSerializerInterface::KEY_VALUE]);
    }

    public function testSerializeOmitsUnsetOptionals(): void
    {
        $event = new DeviceEvent('on');

        $serializer = new DeviceEventSerializer();

        $actual = $serializer->serialize([$event]);

        self::assertSame(
            [
                [DeviceEventSerializerInterface::KEY_VALUE => 'on'],
            ],
            $actual
        );
    }

    public function testSerializeSendsFalsyValue(): void
    {
        $event = new DeviceEvent(0);

        $serializer = new DeviceEventSerializer();

        $actual = $serializer->serialize([$event]);

        self::assertSame(0, $actual[0][DeviceEventSerializerInterface::KEY_VALUE]);
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $event = (new DeviceEvent('active'))
            ->setComponent('main')
            ->setCapability('motionSensor')
            ->setAttribute('motion')
            ->setUnit('boolean')
            ->setData(['foo' => 'bar'])
            ->setCommandId('test-command-id');

        $serializer = new DeviceEventSerializer();

        $actual = $serializer->serialize([$event]);

        self::assertSame(
            [
                [
                    DeviceEventSerializerInterface::KEY_VALUE => 'active',
                    DeviceEventSerializerInterface::KEY_COMPONENT => 'main',
                    DeviceEventSerializerInterface::KEY_CAPABILITY => 'motionSensor',
                    DeviceEventSerializerInterface::KEY_ATTRIBUTE => 'motion',
                    DeviceEventSerializerInterface::KEY_UNIT => 'boolean',
                    DeviceEventSerializerInterface::KEY_DATA => ['foo' => 'bar'],
                    DeviceEventSerializerInterface::KEY_COMMAND_ID => 'test-command-id',
                ],
            ],
            $actual
        );
    }
}
