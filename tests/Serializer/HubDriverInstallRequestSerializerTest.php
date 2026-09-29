<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\HubDriverInstallRequest;
use ChristianBrown\SmartThings\Serializer\HubDriverInstallRequestSerializer;
use ChristianBrown\SmartThings\Serializer\HubDriverInstallRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubDriverInstallRequest::class)]
#[CoversClass(HubDriverInstallRequestSerializer::class)]
final class HubDriverInstallRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new HubDriverInstallRequest();

        $serializer = new HubDriverInstallRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new HubDriverInstallRequest())
            ->setChannelId('test-channel-id');

        $serializer = new HubDriverInstallRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                HubDriverInstallRequestSerializerInterface::KEY_CHANNEL_ID => 'test-channel-id',
            ],
            $actual
        );
    }
}
