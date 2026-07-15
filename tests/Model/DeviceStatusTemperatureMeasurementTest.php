<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceStatusTemperatureMeasurement;
use ChristianBrown\SmartThings\Model\DeviceStatusTemperatureMeasurementTemperatureInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusTemperatureMeasurement::class)]
final class DeviceStatusTemperatureMeasurementTest extends TestCase
{
    public function test(): void
    {
        $temperature = self::createStub(DeviceStatusTemperatureMeasurementTemperatureInterface::class);
        $measurement = new DeviceStatusTemperatureMeasurement($temperature);
        self::assertSame($temperature, $measurement->getTemperature());

        $newTemperature = self::createStub(DeviceStatusTemperatureMeasurementTemperatureInterface::class);
        self::assertSame($measurement, $measurement->setTemperature($newTemperature));
        self::assertSame($newTemperature, $measurement->getTemperature());
    }
}
