<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurement;
use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementHumidityInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusRelativeHumidityMeasurement::class)]
final class DeviceStatusRelativeHumidityMeasurementTest extends TestCase
{
    public function test(): void
    {
        $humidity = self::createStub(DeviceStatusRelativeHumidityMeasurementHumidityInterface::class);
        $measurement = new DeviceStatusRelativeHumidityMeasurement($humidity);
        self::assertSame($humidity, $measurement->getHumidity());

        $newHumidity = self::createStub(DeviceStatusRelativeHumidityMeasurementHumidityInterface::class);
        self::assertSame($measurement, $measurement->setHumidity($newHumidity));
        self::assertSame($newHumidity, $measurement->getHumidity());
    }
}
