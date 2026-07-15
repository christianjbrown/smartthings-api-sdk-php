<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatus;
use ChristianBrown\SmartThings\Model\DeviceStatusBatteryInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusTemperatureMeasurementInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatus::class)]
#[CoversClass(DeviceStatusTransformer::class)]
final class DeviceStatusTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data1 = [
            DeviceStatusTransformerInterface::KEY_TEMPERATURE_MEASUREMENT => ['test-temperature-measurement'],
            DeviceStatusTransformerInterface::KEY_RELATIVE_HUMIDITY_MEASUREMENT => ['test-relative-humidity-measurement'],
            DeviceStatusTransformerInterface::KEY_BATTERY => ['test-battery'],
        ];
        $data2 = [];

        $measurement1 = self::createStub(DeviceStatusTemperatureMeasurementInterface::class);
        $measurementTransformer = self::createStub(DeviceStatusTemperatureMeasurementTransformerInterface::class);
        $measurementTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-temperature-measurement'], $measurement1],
                ]
            );

        $humidityMeasurement1 = self::createStub(DeviceStatusRelativeHumidityMeasurementInterface::class);
        $humidityMeasurementTransformer = self::createStub(DeviceStatusRelativeHumidityMeasurementTransformerInterface::class);
        $humidityMeasurementTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-relative-humidity-measurement'], $humidityMeasurement1],
                ]
            );

        $battery1 = self::createStub(DeviceStatusBatteryInterface::class);
        $batteryTransformer = self::createStub(DeviceStatusBatteryTransformerInterface::class);
        $batteryTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-battery'], $battery1],
                ]
            );

        $transformer = new DeviceStatusTransformer($measurementTransformer, $humidityMeasurementTransformer, $batteryTransformer);

        $actual1 = $transformer->transform($data1);
        self::assertSame($measurement1, $actual1->getTemperatureMeasurement());
        self::assertSame($humidityMeasurement1, $actual1->getRelativeHumidityMeasurement());
        self::assertSame($battery1, $actual1->getBattery());

        $actual2 = $transformer->transform($data2);
        self::assertNull($actual2->getTemperatureMeasurement());
        self::assertNull($actual2->getRelativeHumidityMeasurement());
        self::assertNull($actual2->getBattery());

        $data3 = [
            DeviceStatusTransformerInterface::KEY_TEMPERATURE_MEASUREMENT => 'not-an-array',
            DeviceStatusTransformerInterface::KEY_RELATIVE_HUMIDITY_MEASUREMENT => 'not-an-array',
            DeviceStatusTransformerInterface::KEY_BATTERY => 'not-an-array',
        ];
        $actual3 = $transformer->transform($data3);
        self::assertNull($actual3->getTemperatureMeasurement());
        self::assertNull($actual3->getRelativeHumidityMeasurement());
        self::assertNull($actual3->getBattery());
    }

    /**
     * Exercises every combination of the three optional measurement blocks
     * (temperature, relative humidity, battery), each absent, present-but-wrong-type,
     * or present-and-valid, covering all paths through every nested block.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformMeasurementCombinationsCases')]
    public function testTransformMeasurementCombinations(array $data, bool $expectTemperature, bool $expectHumidity, bool $expectBattery): void
    {
        $temperature = self::createStub(DeviceStatusTemperatureMeasurementInterface::class);
        $measurementTransformer = self::createMock(DeviceStatusTemperatureMeasurementTransformerInterface::class);
        if ($expectTemperature) {
            $measurementTransformer->expects(self::once())
                ->method('transform')
                ->with($data[DeviceStatusTransformerInterface::KEY_TEMPERATURE_MEASUREMENT])
                ->willReturn($temperature);
        } else {
            $measurementTransformer->expects(self::never())->method('transform');
        }

        $humidity = self::createStub(DeviceStatusRelativeHumidityMeasurementInterface::class);
        $humidityMeasurementTransformer = self::createMock(DeviceStatusRelativeHumidityMeasurementTransformerInterface::class);
        if ($expectHumidity) {
            $humidityMeasurementTransformer->expects(self::once())
                ->method('transform')
                ->with($data[DeviceStatusTransformerInterface::KEY_RELATIVE_HUMIDITY_MEASUREMENT])
                ->willReturn($humidity);
        } else {
            $humidityMeasurementTransformer->expects(self::never())->method('transform');
        }

        $battery = self::createStub(DeviceStatusBatteryInterface::class);
        $batteryTransformer = self::createMock(DeviceStatusBatteryTransformerInterface::class);
        if ($expectBattery) {
            $batteryTransformer->expects(self::once())
                ->method('transform')
                ->with($data[DeviceStatusTransformerInterface::KEY_BATTERY])
                ->willReturn($battery);
        } else {
            $batteryTransformer->expects(self::never())->method('transform');
        }

        $transformer = new DeviceStatusTransformer($measurementTransformer, $humidityMeasurementTransformer, $batteryTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($expectTemperature ? $temperature : null, $actual->getTemperatureMeasurement());
        self::assertSame($expectHumidity ? $humidity : null, $actual->getRelativeHumidityMeasurement());
        self::assertSame($expectBattery ? $battery : null, $actual->getBattery());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, bool, bool, bool}>
     */
    public static function provideTransformMeasurementCombinationsCases(): iterable
    {
        $states = [
            'Absent' => [null, false],
            'WrongType' => ['not-an-array', false],
            'Valid' => [['data'], true],
        ];

        foreach ($states as $temperatureName => [$temperatureValue, $expectTemperature]) {
            foreach ($states as $humidityName => [$humidityValue, $expectHumidity]) {
                foreach ($states as $batteryName => [$batteryValue, $expectBattery]) {
                    $data = [];
                    if (null !== $temperatureValue) {
                        $data[DeviceStatusTransformerInterface::KEY_TEMPERATURE_MEASUREMENT] = $temperatureValue;
                    }
                    if (null !== $humidityValue) {
                        $data[DeviceStatusTransformerInterface::KEY_RELATIVE_HUMIDITY_MEASUREMENT] = $humidityValue;
                    }
                    if (null !== $batteryValue) {
                        $data[DeviceStatusTransformerInterface::KEY_BATTERY] = $batteryValue;
                    }

                    yield sprintf('temperature%s, humidity%s, battery%s', $temperatureName, $humidityName, $batteryName) => [
                        $data,
                        $expectTemperature,
                        $expectHumidity,
                        $expectBattery,
                    ];
                }
            }
        }
    }
}
