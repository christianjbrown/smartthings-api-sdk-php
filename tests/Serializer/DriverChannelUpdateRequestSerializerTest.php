<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DriverChannelUpdateRequest;
use ChristianBrown\SmartThings\Serializer\DriverChannelUpdateRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DriverChannelUpdateRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DriverChannelUpdateRequest::class)]
#[CoversClass(DriverChannelUpdateRequestSerializer::class)]
final class DriverChannelUpdateRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new DriverChannelUpdateRequest();

        $serializer = new DriverChannelUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new DriverChannelUpdateRequest())
            ->setVersion('test-version');

        $serializer = new DriverChannelUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                DriverChannelUpdateRequestSerializerInterface::KEY_VERSION => 'test-version',
            ],
            $actual
        );
    }
}
