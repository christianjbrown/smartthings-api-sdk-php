<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscription;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceLocationInfoSubscription::class)]
final class ServiceLocationInfoSubscriptionTest extends TestCase
{
    public function test(): void
    {
        $subscription = new ServiceLocationInfoSubscription('test-subscription-id');
        self::assertSame('test-subscription-id', $subscription->getSubscriptionId());
        self::assertNull($subscription->getPredicate());
        self::assertNull($subscription->getType());
        self::assertSame([], $subscription->getSubscribedCapabilities());

        self::assertSame($subscription, $subscription->setSubscriptionId('test-new-subscription-id'));
        self::assertSame($subscription, $subscription->setPredicate('weather.temperature.value > 4'));
        self::assertSame($subscription, $subscription->setType('DIRECT'));
        self::assertSame($subscription, $subscription->setSubscribedCapabilities(['weather', 'airQuality']));

        self::assertSame('test-new-subscription-id', $subscription->getSubscriptionId());
        self::assertSame('weather.temperature.value > 4', $subscription->getPredicate());
        self::assertSame('DIRECT', $subscription->getType());
        self::assertSame(['weather', 'airQuality'], $subscription->getSubscribedCapabilities());
    }
}
