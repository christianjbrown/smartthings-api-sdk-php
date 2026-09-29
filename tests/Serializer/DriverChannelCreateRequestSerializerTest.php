<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DriverChannelCreateRequest;
use ChristianBrown\SmartThings\Serializer\DriverChannelCreateRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DriverChannelCreateRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DriverChannelCreateRequest::class)]
#[CoversClass(DriverChannelCreateRequestSerializer::class)]
final class DriverChannelCreateRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new DriverChannelCreateRequest();

        $serializer = new DriverChannelCreateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new DriverChannelCreateRequest())
            ->setDriverId('test-driver-id')
            ->setVersion('test-version');

        $serializer = new DriverChannelCreateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                DriverChannelCreateRequestSerializerInterface::KEY_DRIVER_ID => 'test-driver-id',
                DriverChannelCreateRequestSerializerInterface::KEY_VERSION => 'test-version',
            ],
            $actual
        );
    }
}
