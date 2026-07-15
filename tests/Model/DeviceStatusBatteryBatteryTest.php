<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceStatusBatteryBattery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusBatteryBattery::class)]
final class DeviceStatusBatteryBatteryTest extends TestCase
{
    public function test(): void
    {
        $battery = new DeviceStatusBatteryBattery(42, 'test-unit', 56);
        self::assertSame(42, $battery->getTimestamp());
        self::assertSame('test-unit', $battery->getUnit());
        self::assertSame(56, $battery->getValue());

        self::assertSame($battery, $battery->setTimestamp(43));
        self::assertSame($battery, $battery->setUnit('test-new-unit'));
        self::assertSame($battery, $battery->setValue(78));

        self::assertSame(43, $battery->getTimestamp());
        self::assertSame('test-new-unit', $battery->getUnit());
        self::assertSame(78, $battery->getValue());
    }
}
