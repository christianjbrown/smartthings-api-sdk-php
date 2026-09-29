<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\IndoorMapInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceComponentInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceRequest;
use ChristianBrown\SmartThings\Serializer\IndoorMapSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceComponentSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateDeviceRequest::class)]
#[CoversClass(UpdateDeviceRequestSerializer::class)]
final class UpdateDeviceRequestSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $updateDeviceComponentModel = self::createStub(UpdateDeviceComponentInterface::class);
        $updateDeviceComponentSerializer = self::createStub(UpdateDeviceComponentSerializerInterface::class);
        $updateDeviceComponentSerializer->method('serialize')->willReturn(['test-serialized-update-device-component']);
        $indoorMapModel = self::createStub(IndoorMapInterface::class);
        $indoorMapSerializer = self::createStub(IndoorMapSerializerInterface::class);
        $indoorMapSerializer->method('serialize')->willReturn(['test-serialized-indoor-map']);
        $model = new UpdateDeviceRequest();

        $serializer = new UpdateDeviceRequestSerializer($updateDeviceComponentSerializer, $indoorMapSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $updateDeviceComponentModel = self::createStub(UpdateDeviceComponentInterface::class);
        $updateDeviceComponentSerializer = self::createStub(UpdateDeviceComponentSerializerInterface::class);
        $updateDeviceComponentSerializer->method('serialize')->willReturn(['test-serialized-update-device-component']);
        $indoorMapModel = self::createStub(IndoorMapInterface::class);
        $indoorMapSerializer = self::createStub(IndoorMapSerializerInterface::class);
        $indoorMapSerializer->method('serialize')->willReturn(['test-serialized-indoor-map']);
        $model = (new UpdateDeviceRequest())
            ->setLabel('test-label')
            ->setLocationId('test-location-id')
            ->setRoomId('test-room-id')
            ->setComponents([$updateDeviceComponentModel])
            ->setIndoorMap($indoorMapModel);

        $serializer = new UpdateDeviceRequestSerializer($updateDeviceComponentSerializer, $indoorMapSerializer);

        self::assertSame(
            [
                UpdateDeviceRequestSerializerInterface::KEY_LABEL => 'test-label',
                UpdateDeviceRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                UpdateDeviceRequestSerializerInterface::KEY_ROOM_ID => 'test-room-id',
                UpdateDeviceRequestSerializerInterface::KEY_COMPONENTS => [['test-serialized-update-device-component']],
                UpdateDeviceRequestSerializerInterface::KEY_INDOOR_MAP => ['test-serialized-indoor-map'],
            ],
            $serializer->serialize($model)
        );
    }
}
