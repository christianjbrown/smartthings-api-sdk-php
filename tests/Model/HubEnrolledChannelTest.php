<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\HubEnrolledChannel;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubEnrolledChannel::class)]
final class HubEnrolledChannelTest extends TestCase
{
    public function test(): void
    {
        $channel = new HubEnrolledChannel('test-channel-id');
        self::assertSame('test-channel-id', $channel->getChannelId());
        self::assertNull($channel->getDescription());
        self::assertNull($channel->getName());
        self::assertNull($channel->getSubscriptionUrl());

        self::assertSame($channel, $channel->setChannelId('test-new-channel-id'));
        self::assertSame($channel, $channel->setDescription('Test description'));
        self::assertSame($channel, $channel->setName('Test Channel'));
        self::assertSame($channel, $channel->setSubscriptionUrl('https://example.com/subscribe'));

        self::assertSame('test-new-channel-id', $channel->getChannelId());
        self::assertSame('Test description', $channel->getDescription());
        self::assertSame('Test Channel', $channel->getName());
        self::assertSame('https://example.com/subscribe', $channel->getSubscriptionUrl());
    }
}
