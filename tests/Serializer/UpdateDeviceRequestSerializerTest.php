<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\UpdateDeviceRequest;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateDeviceRequest::class)]
#[CoversClass(UpdateDeviceRequestSerializer::class)]
final class UpdateDeviceRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new UpdateDeviceRequest();

        $serializer = new UpdateDeviceRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame([], $actual);
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new UpdateDeviceRequest())
            ->setLabel('test-label')
            ->setLocationId('test-location-id')
            ->setRoomId('test-room-id');

        $serializer = new UpdateDeviceRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateDeviceRequestSerializerInterface::KEY_LABEL => 'test-label',
                UpdateDeviceRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                UpdateDeviceRequestSerializerInterface::KEY_ROOM_ID => 'test-room-id',
            ],
            $actual
        );
    }
}
