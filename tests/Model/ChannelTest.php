<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Channel;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Channel::class)]
final class ChannelTest extends TestCase
{
    public function test(): void
    {
        $channel = new Channel('test-channel-id');
        self::assertSame('test-channel-id', $channel->getChannelId());
        self::assertNull($channel->getDescription());
        self::assertNull($channel->getName());
        self::assertNull($channel->getTermsOfServiceUrl());
        self::assertNull($channel->getType());

        self::assertSame($channel, $channel->setChannelId('test-new-channel-id'));
        self::assertSame($channel, $channel->setDescription('Test description'));
        self::assertSame($channel, $channel->setName('Test Channel'));
        self::assertSame($channel, $channel->setTermsOfServiceUrl('https://example.com/tos'));
        self::assertSame($channel, $channel->setType('DRIVER'));

        self::assertSame('test-new-channel-id', $channel->getChannelId());
        self::assertSame('Test description', $channel->getDescription());
        self::assertSame('Test Channel', $channel->getName());
        self::assertSame('https://example.com/tos', $channel->getTermsOfServiceUrl());
        self::assertSame('DRIVER', $channel->getType());
    }
}
