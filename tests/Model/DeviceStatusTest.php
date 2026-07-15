<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceStatus;
use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusTemperatureMeasurementInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatus::class)]
final class DeviceStatusTest extends TestCase
{
    public function test(): void
    {
        $status = new DeviceStatus();
        self::assertNull($status->getTemperatureMeasurement());
        $temperatureMeasurement = self::createStub(DeviceStatusTemperatureMeasurementInterface::class);
        self::assertSame($status, $status->setTemperatureMeasurement($temperatureMeasurement));
        self::assertSame($temperatureMeasurement, $status->getTemperatureMeasurement());

        self::assertNull($status->getRelativeHumidityMeasurement());
        $relativeHumidityMeasurement = self::createStub(DeviceStatusRelativeHumidityMeasurementInterface::class);
        self::assertSame($status, $status->setRelativeHumidityMeasurement($relativeHumidityMeasurement));
        self::assertSame($relativeHumidityMeasurement, $status->getRelativeHumidityMeasurement());
    }
}
