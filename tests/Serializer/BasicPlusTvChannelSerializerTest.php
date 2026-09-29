<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvChannel;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvChannelSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvChannelSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTvChannel::class)]
#[CoversClass(BasicPlusTvChannelSerializer::class)]
final class BasicPlusTvChannelSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $basicPlusTvVolumeCommandModel = self::createStub(BasicPlusTvVolumeCommandInterface::class);
        $basicPlusTvVolumeCommandSerializer = self::createStub(BasicPlusTvVolumeCommandSerializerInterface::class);
        $basicPlusTvVolumeCommandSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-volume-command']);
        $model = new BasicPlusTvChannel('test-capability', 'test-component', $basicPlusTvVolumeCommandModel);

        $serializer = new BasicPlusTvChannelSerializer($basicPlusTvVolumeCommandSerializer);

        self::assertSame(
            [
                BasicPlusTvChannelSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusTvChannelSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusTvChannelSerializerInterface::KEY_COMMAND => ['test-serialized-basic-plus-tv-volume-command'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $basicPlusTvVolumeCommandModel = self::createStub(BasicPlusTvVolumeCommandInterface::class);
        $basicPlusTvVolumeCommandSerializer = self::createStub(BasicPlusTvVolumeCommandSerializerInterface::class);
        $basicPlusTvVolumeCommandSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-volume-command']);
        $model = (new BasicPlusTvChannel('test-capability', 'test-component', $basicPlusTvVolumeCommandModel))
            ->setVersion(7)
            ->setLabel('test-label')
            ->setValue('test-value');

        $serializer = new BasicPlusTvChannelSerializer($basicPlusTvVolumeCommandSerializer);

        self::assertSame(
            [
                BasicPlusTvChannelSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusTvChannelSerializerInterface::KEY_VERSION => 7,
                BasicPlusTvChannelSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusTvChannelSerializerInterface::KEY_LABEL => 'test-label',
                BasicPlusTvChannelSerializerInterface::KEY_VALUE => 'test-value',
                BasicPlusTvChannelSerializerInterface::KEY_COMMAND => ['test-serialized-basic-plus-tv-volume-command'],
            ],
            $serializer->serialize($model)
        );
    }
}
