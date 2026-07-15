<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceStatusBatteryBattery;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryBatteryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusBatteryBattery::class)]
#[CoversClass(DeviceStatusBatteryBatteryTransformer::class)]
final class DeviceStatusBatteryBatteryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 56,
            DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT => '%',
        ];

        $transformer = new DeviceStatusBatteryBatteryTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1612355696, $actual->getTimestamp());
        self::assertSame(56, $actual->getValue());
        self::assertSame('%', $actual->getUnit());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([
        [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP => 42,
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 56,
            DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusBatteryBatteryTransformerInterface::UNEXPECTED_STRING_SPRINTF,
        DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP,
    ])]
    #[TestWith([
        [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 56,
            DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusBatteryBatteryTransformerInterface::UNEXPECTED_STRING_SPRINTF,
        DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP,
    ])]
    #[TestWith([
        [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP => 'test-not-a-timestamp',
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 56,
            DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusBatteryBatteryTransformerInterface::UNEXPECTED_DATA_TIMESTAMP,
        DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP,
    ])]
    #[TestWith([
        [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusBatteryBatteryTransformerInterface::UNEXPECTED_INT_SPRINTF,
        DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE,
    ])]
    #[TestWith([
        [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 55.0,
            DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusBatteryBatteryTransformerInterface::UNEXPECTED_INT_SPRINTF,
        DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE,
    ])]
    #[TestWith([
        [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 'test-not-an-int',
            DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT => '%',
        ],
        DeviceStatusBatteryBatteryTransformerInterface::UNEXPECTED_INT_SPRINTF,
        DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE,
    ])]
    #[TestWith([
        [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 56,
        ],
        DeviceStatusBatteryBatteryTransformerInterface::UNEXPECTED_STRING_SPRINTF,
        DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT,
    ])]
    #[TestWith([
        [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 56,
            DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT => ['test-not-a-string'],
        ],
        DeviceStatusBatteryBatteryTransformerInterface::UNEXPECTED_STRING_SPRINTF,
        DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT,
    ])]
    public function testTransformUnexpectedData(array $data, string $exceptionMessage, string $exceptionMessageField): void
    {
        $transformer = new DeviceStatusBatteryBatteryTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf($exceptionMessage, $exceptionMessageField));
        $transformer->transform($data);
    }

    public function testTransformZeroValue(): void
    {
        $data = [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_TIMESTAMP => '2021-02-03 12:34:56',
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 0,
            DeviceStatusBatteryBatteryTransformerInterface::KEY_UNIT => '%',
        ];

        $transformer = new DeviceStatusBatteryBatteryTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(0, $actual->getValue());
    }
}
