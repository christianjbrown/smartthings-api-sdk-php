<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceHistoryEvent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceHistoryEvent::class)]
final class DeviceHistoryEventTest extends TestCase
{
    public function test(): void
    {
        $event = new DeviceHistoryEvent('test-device-id');
        self::assertSame('test-device-id', $event->getDeviceId());
        self::assertNull($event->getAttribute());
        self::assertNull($event->getCapability());
        self::assertNull($event->getComponent());
        self::assertNull($event->getEpoch());
        self::assertNull($event->getLocationId());
        self::assertNull($event->getValue());

        self::assertSame($event, $event->setDeviceId('test-new-device-id'));
        self::assertSame($event, $event->setAttribute('switch'));
        self::assertSame($event, $event->setCapability('switch'));
        self::assertSame($event, $event->setComponent('main'));
        self::assertSame($event, $event->setEpoch(1610712000000));
        self::assertSame($event, $event->setLocationId('test-location-id'));
        self::assertSame($event, $event->setValue('on'));

        self::assertSame('test-new-device-id', $event->getDeviceId());
        self::assertSame('switch', $event->getAttribute());
        self::assertSame('switch', $event->getCapability());
        self::assertSame('main', $event->getComponent());
        self::assertSame(1610712000000, $event->getEpoch());
        self::assertSame('test-location-id', $event->getLocationId());
        self::assertSame('on', $event->getValue());
    }
}
