<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\ServiceLocationInfo;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscriptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceLocationInfo::class)]
final class ServiceLocationInfoTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test(): void
    {
        $info = new ServiceLocationInfo('test-location-id');
        self::assertSame('test-location-id', $info->getLocationId());
        self::assertNull($info->getCity());
        self::assertNull($info->getLatitude());
        self::assertNull($info->getLongitude());
        self::assertSame([], $info->getSubscriptions());

        $subscriptions = [self::createStub(ServiceLocationInfoSubscriptionInterface::class)];

        self::assertSame($info, $info->setLocationId('test-new-location-id'));
        self::assertSame($info, $info->setCity('Minneapolis'));
        self::assertSame($info, $info->setLatitude(44.98));
        self::assertSame($info, $info->setLongitude(-93.27));
        self::assertSame($info, $info->setSubscriptions($subscriptions));

        self::assertSame('test-new-location-id', $info->getLocationId());
        self::assertSame('Minneapolis', $info->getCity());
        self::assertSame(44.98, $info->getLatitude());
        self::assertSame(-93.27, $info->getLongitude());
        self::assertSame($subscriptions, $info->getSubscriptions());
    }
}
