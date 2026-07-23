<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\ServiceMeasurement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceMeasurement::class)]
final class ServiceMeasurementTest extends TestCase
{
    public function test(): void
    {
        $measurement = new ServiceMeasurement(6);
        self::assertSame(6, $measurement->getValue());
        self::assertNull($measurement->getUnit());

        self::assertSame($measurement, $measurement->setValue(16.09));
        self::assertSame($measurement, $measurement->setUnit('Km'));

        self::assertSame(16.09, $measurement->getValue());
        self::assertSame('Km', $measurement->getUnit());

        self::assertSame($measurement, $measurement->setValue('Partly Cloudy'));
        self::assertSame('Partly Cloudy', $measurement->getValue());
    }
}
