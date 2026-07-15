<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementHumidity;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementHumidityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusRelativeHumidityMeasurementHumidity::class)]
#[CoversClass(DeviceStatusRelativeHumidityMeasurementHumidityTransformer::class)]
final class DeviceStatusRelativeHumidityMeasurementHumidityTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE => 56,
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT => '%',
        ];

        $transformer = new DeviceStatusRelativeHumidityMeasurementHumidityTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1612355696, $actual->getTimestamp());
        self::assertSame(56.0, $actual->getValue());
        self::assertSame('%', $actual->getUnit());
    }

    public function testTransformFloatValue(): void
    {
        $data = [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE => 55.0,
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT => '%',
        ];

        $transformer = new DeviceStatusRelativeHumidityMeasurementHumidityTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(55.0, $actual->getValue());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([
        [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP => 42,
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE => 56,
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::UNEXPECTED_STRING_SPRINTF,
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP,
    ])]
    #[TestWith([
        [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE => 56,
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::UNEXPECTED_STRING_SPRINTF,
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP,
    ])]
    #[TestWith([
        [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP => 'test-not-a-timestamp',
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE => 56,
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::UNEXPECTED_DATA_TIMESTAMP,
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP,
    ])]
    #[TestWith([
        [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::UNEXPECTED_FLOAT_SPRINTF,
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE,
    ])]
    #[TestWith([
        [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE => 'test-not-a-float',
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::UNEXPECTED_FLOAT_SPRINTF,
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE,
    ])]
    #[TestWith([
        [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE => 56,
        ],
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::UNEXPECTED_STRING_SPRINTF,
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT,
    ])]
    #[TestWith([
        [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE => 56,
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT => ['test-not-a-string'],
        ],
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::UNEXPECTED_STRING_SPRINTF,
        DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT,
    ])]
    public function testTransformUnexpectedData(array $data, string $exceptionMessage, string $exceptionMessageField): void
    {
        $transformer = new DeviceStatusRelativeHumidityMeasurementHumidityTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf($exceptionMessage, $exceptionMessageField));
        $transformer->transform($data);
    }

    public function testTransformZeroValue(): void
    {
        $data = [
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_VALUE => 0,
            DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface::KEY_UNIT => '%',
        ];

        $transformer = new DeviceStatusRelativeHumidityMeasurementHumidityTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(0.0, $actual->getValue());
    }
}
