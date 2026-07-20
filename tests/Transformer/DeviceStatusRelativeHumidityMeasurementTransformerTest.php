<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurement;
use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementHumidityInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusRelativeHumidityMeasurement::class)]
#[CoversClass(DeviceStatusRelativeHumidityMeasurementTransformer::class)]
final class DeviceStatusRelativeHumidityMeasurementTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceStatusRelativeHumidityMeasurementTransformerInterface::KEY_HUMIDITY => ['test-humidity'],
        ];

        $humidity = self::createStub(DeviceStatusRelativeHumidityMeasurementHumidityInterface::class);

        $humidityTransformer = self::createMock(DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::class);
        $humidityTransformer->expects(self::once())->method('transform')
            ->with(['test-humidity'])
            ->willReturn($humidity);

        $transformer = new DeviceStatusRelativeHumidityMeasurementTransformer($humidityTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($humidity, $actual->getHumidity());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DeviceStatusRelativeHumidityMeasurementTransformerInterface::KEY_HUMIDITY => 'test-not-an-array']])]
    public function testTransformUnexpectedData(array $data): void
    {
        $humidityTransformer = self::createStub(DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::class);
        $transformer = new DeviceStatusRelativeHumidityMeasurementTransformer($humidityTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceStatusRelativeHumidityMeasurementTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceStatusRelativeHumidityMeasurementTransformerInterface::KEY_HUMIDITY));
        $transformer->transform($data);
    }
}
