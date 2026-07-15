<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementHumidity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusRelativeHumidityMeasurementHumidity::class)]
final class DeviceStatusRelativeHumidityMeasurementHumidityTest extends TestCase
{
    public function test(): void
    {
        $humidity = new DeviceStatusRelativeHumidityMeasurementHumidity(42, 'test-unit', 56.0);
        self::assertSame(42, $humidity->getTimestamp());
        self::assertSame('test-unit', $humidity->getUnit());
        self::assertSame(56.0, $humidity->getValue());

        self::assertSame($humidity, $humidity->setTimestamp(43));
        self::assertSame($humidity, $humidity->setUnit('test-new-unit'));
        self::assertSame($humidity, $humidity->setValue(78.0));

        self::assertSame(43, $humidity->getTimestamp());
        self::assertSame('test-new-unit', $humidity->getUnit());
        self::assertSame(78.0, $humidity->getValue());
    }
}
