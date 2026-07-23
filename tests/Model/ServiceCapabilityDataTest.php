<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\ServiceCapabilityData;
use ChristianBrown\SmartThings\Model\ServiceMeasurementInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceCapabilityData::class)]
final class ServiceCapabilityDataTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test(): void
    {
        $capabilityData = new ServiceCapabilityData('test-location-id');
        self::assertSame('test-location-id', $capabilityData->getLocationId());
        self::assertSame([], $capabilityData->getAirQuality());
        self::assertSame([], $capabilityData->getAirQualityForecast());
        self::assertSame([], $capabilityData->getForecast());
        self::assertSame([], $capabilityData->getWeather());

        $airQuality = ['airQualityIndex' => self::createStub(ServiceMeasurementInterface::class)];
        $airQualityForecast = ['index' => self::createStub(ServiceMeasurementInterface::class)];
        $forecast = ['precip1Hour' => self::createStub(ServiceMeasurementInterface::class)];
        $weather = ['temperature' => self::createStub(ServiceMeasurementInterface::class)];

        self::assertSame($capabilityData, $capabilityData->setLocationId('test-new-location-id'));
        self::assertSame($capabilityData, $capabilityData->setAirQuality($airQuality));
        self::assertSame($capabilityData, $capabilityData->setAirQualityForecast($airQualityForecast));
        self::assertSame($capabilityData, $capabilityData->setForecast($forecast));
        self::assertSame($capabilityData, $capabilityData->setWeather($weather));

        self::assertSame('test-new-location-id', $capabilityData->getLocationId());
        self::assertSame($airQuality, $capabilityData->getAirQuality());
        self::assertSame($airQualityForecast, $capabilityData->getAirQualityForecast());
        self::assertSame($forecast, $capabilityData->getForecast());
        self::assertSame($weather, $capabilityData->getWeather());
    }
}
