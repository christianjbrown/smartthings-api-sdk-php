<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatus;
use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusTemperatureMeasurementInterface;
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

        $transformer = new DeviceStatusTransformer($measurementTransformer, $humidityMeasurementTransformer);

        $actual1 = $transformer->transform($data1);
        self::assertSame($measurement1, $actual1->getTemperatureMeasurement());
        self::assertSame($humidityMeasurement1, $actual1->getRelativeHumidityMeasurement());

        $actual2 = $transformer->transform($data2);
        self::assertNull($actual2->getTemperatureMeasurement());
        self::assertNull($actual2->getRelativeHumidityMeasurement());

        $data3 = [
            DeviceStatusTransformerInterface::KEY_TEMPERATURE_MEASUREMENT => 'not-an-array',
            DeviceStatusTransformerInterface::KEY_RELATIVE_HUMIDITY_MEASUREMENT => 'not-an-array',
        ];
        $actual3 = $transformer->transform($data3);
        self::assertNull($actual3->getTemperatureMeasurement());
        self::assertNull($actual3->getRelativeHumidityMeasurement());
    }

    /**
     * Exercises every combination of the two optional measurement blocks
     * (temperature, relative humidity), each absent, present-but-wrong-type, or
     * present-and-valid, covering all paths through both nested blocks.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformMeasurementCombinationsCases')]
    public function testTransformMeasurementCombinations(array $data, bool $expectTemperature, bool $expectHumidity): void
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

        $transformer = new DeviceStatusTransformer($measurementTransformer, $humidityMeasurementTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($expectTemperature ? $temperature : null, $actual->getTemperatureMeasurement());
        self::assertSame($expectHumidity ? $humidity : null, $actual->getRelativeHumidityMeasurement());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, bool, bool}>
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
                $data = [];
                if (null !== $temperatureValue) {
                    $data[DeviceStatusTransformerInterface::KEY_TEMPERATURE_MEASUREMENT] = $temperatureValue;
                }
                if (null !== $humidityValue) {
                    $data[DeviceStatusTransformerInterface::KEY_RELATIVE_HUMIDITY_MEASUREMENT] = $humidityValue;
                }

                yield sprintf('temperature%s, humidity%s', $temperatureName, $humidityName) => [
                    $data,
                    $expectTemperature,
                    $expectHumidity,
                ];
            }
        }
    }
}
