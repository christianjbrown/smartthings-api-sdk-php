<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceStatusBattery;
use ChristianBrown\SmartThings\Model\DeviceStatusBatteryBatteryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusBattery::class)]
final class DeviceStatusBatteryTest extends TestCase
{
    public function test(): void
    {
        $battery = self::createStub(DeviceStatusBatteryBatteryInterface::class);
        $measurement = new DeviceStatusBattery($battery);
        self::assertSame($battery, $measurement->getBattery());

        $newBattery = self::createStub(DeviceStatusBatteryBatteryInterface::class);
        self::assertSame($measurement, $measurement->setBattery($newBattery));
        self::assertSame($newBattery, $measurement->getBattery());
    }
}
