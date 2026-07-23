<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\ChannelDriver;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ChannelDriver::class)]
final class ChannelDriverTest extends TestCase
{
    public function test(): void
    {
        $channelDriver = new ChannelDriver('test-driver-id');
        self::assertSame('test-driver-id', $channelDriver->getDriverId());
        self::assertNull($channelDriver->getChannelId());
        self::assertNull($channelDriver->getVersion());

        self::assertSame($channelDriver, $channelDriver->setDriverId('test-new-driver-id'));
        self::assertSame($channelDriver, $channelDriver->setChannelId('test-channel-id'));
        self::assertSame($channelDriver, $channelDriver->setVersion('2024-01-01'));

        self::assertSame('test-new-driver-id', $channelDriver->getDriverId());
        self::assertSame('test-channel-id', $channelDriver->getChannelId());
        self::assertSame('2024-01-01', $channelDriver->getVersion());
    }
}
