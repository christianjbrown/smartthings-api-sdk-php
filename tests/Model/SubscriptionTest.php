<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Subscription;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Subscription::class)]
final class SubscriptionTest extends TestCase
{
    public function test(): void
    {
        $subscription = new Subscription('test-subscription-id');
        self::assertSame('test-subscription-id', $subscription->getId());
        self::assertNull($subscription->getInstalledAppId());
        self::assertNull($subscription->getSourceType());

        self::assertSame($subscription, $subscription->setId('test-new-subscription-id'));
        self::assertSame($subscription, $subscription->setInstalledAppId('test-installed-app-id'));
        self::assertSame($subscription, $subscription->setSourceType('DEVICE'));

        self::assertSame('test-new-subscription-id', $subscription->getId());
        self::assertSame('test-installed-app-id', $subscription->getInstalledAppId());
        self::assertSame('DEVICE', $subscription->getSourceType());
    }
}
