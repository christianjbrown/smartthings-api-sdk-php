<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceCapabilityData;
use ChristianBrown\SmartThings\Model\ServiceMeasurementInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ServiceCapabilityDataTransformer::class)]
#[UsesClass(ServiceCapabilityData::class)]
final class ServiceCapabilityDataTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [
            ServiceCapabilityDataTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            ServiceCapabilityDataTransformerInterface::KEY_AIR_QUALITY => ['test-air-quality'],
            ServiceCapabilityDataTransformerInterface::KEY_AIR_QUALITY_FORECAST => ['test-air-quality-forecast'],
            ServiceCapabilityDataTransformerInterface::KEY_FORECAST => ['test-forecast'],
            ServiceCapabilityDataTransformerInterface::KEY_WEATHER => ['test-weather'],
        ];

        $airQuality = ['airQualityIndex' => self::createStub(ServiceMeasurementInterface::class)];
        $airQualityForecast = ['index' => self::createStub(ServiceMeasurementInterface::class)];
        $forecast = ['precip1Hour' => self::createStub(ServiceMeasurementInterface::class)];
        $weather = ['temperature' => self::createStub(ServiceMeasurementInterface::class)];

        $measurementsTransformer = self::createMock(ServiceMeasurementsTransformerInterface::class);
        $measurementsTransformer->expects(self::exactly(4))
            ->method('transform')
            ->willReturn($airQuality, $airQualityForecast, $forecast, $weather);

        $transformer = new ServiceCapabilityDataTransformer($measurementsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame($airQuality, $actual->getAirQuality());
        self::assertSame($airQualityForecast, $actual->getAirQualityForecast());
        self::assertSame($forecast, $actual->getForecast());
        self::assertSame($weather, $actual->getWeather());
    }

    /**
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith(['not-an-array'])]
    public function testTransformSkipsAbsentOrInvalidCategories(mixed $categoryValue): void
    {
        $data = [
            ServiceCapabilityDataTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            ServiceCapabilityDataTransformerInterface::KEY_AIR_QUALITY => $categoryValue,
            ServiceCapabilityDataTransformerInterface::KEY_AIR_QUALITY_FORECAST => $categoryValue,
            ServiceCapabilityDataTransformerInterface::KEY_FORECAST => $categoryValue,
            ServiceCapabilityDataTransformerInterface::KEY_WEATHER => $categoryValue,
        ];

        $measurementsTransformer = self::createMock(ServiceMeasurementsTransformerInterface::class);
        $measurementsTransformer->expects(self::never())
            ->method('transform');

        $transformer = new ServiceCapabilityDataTransformer($measurementsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame([], $actual->getAirQuality());
        self::assertSame([], $actual->getAirQualityForecast());
        self::assertSame([], $actual->getForecast());
        self::assertSame([], $actual->getWeather());
    }

    /**
     * @param mixed[] $data
     *
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[ServiceCapabilityDataTransformerInterface::KEY_LOCATION_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ServiceCapabilityDataTransformer(self::createStub(ServiceMeasurementsTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ServiceCapabilityDataTransformerInterface::UNEXPECTED_STRING_SPRINTF, ServiceCapabilityDataTransformerInterface::KEY_LOCATION_ID));
        $transformer->transform($data);
    }
}
