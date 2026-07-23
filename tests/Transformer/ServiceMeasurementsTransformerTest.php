<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceMeasurementInterface;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementsTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ServiceMeasurementsTransformer::class)]
final class ServiceMeasurementsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [
            'temperature' => ['test-temperature'],
            'relativeHumidity' => ['test-humidity'],
        ];

        $temperature = self::createStub(ServiceMeasurementInterface::class);
        $humidity = self::createStub(ServiceMeasurementInterface::class);

        $measurementTransformer = self::createMock(ServiceMeasurementTransformerInterface::class);
        $measurementTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($temperature, $humidity);

        $transformer = new ServiceMeasurementsTransformer($measurementTransformer);

        // The result preserves the field-name keys.
        self::assertSame(['temperature' => $temperature, 'relativeHumidity' => $humidity], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $measurementTransformer = self::createMock(ServiceMeasurementTransformerInterface::class);
        $measurementTransformer->expects(self::never())
            ->method('transform');

        $transformer = new ServiceMeasurementsTransformer($measurementTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $measurementTransformer = self::createStub(ServiceMeasurementTransformerInterface::class);

        $transformer = new ServiceMeasurementsTransformer($measurementTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ServiceMeasurementsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ServiceMeasurementsTransformerInterface::ARRAY_NAME));
        $transformer->transform(['temperature' => 'not-an-array']);
    }
}
