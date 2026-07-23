<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceHealth;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceHealth::class)]
final class DeviceHealthTest extends TestCase
{
    public function test(): void
    {
        $health = new DeviceHealth('test-device-id');
        self::assertSame('test-device-id', $health->getDeviceId());
        self::assertNull($health->getLastUpdatedDate());
        self::assertNull($health->getState());

        self::assertSame($health, $health->setDeviceId('test-new-device-id'));
        self::assertSame($health, $health->setLastUpdatedDate(1610712000));
        self::assertSame($health, $health->setState('ONLINE'));

        self::assertSame('test-new-device-id', $health->getDeviceId());
        self::assertSame(1610712000, $health->getLastUpdatedDate());
        self::assertSame('ONLINE', $health->getState());
    }
}
