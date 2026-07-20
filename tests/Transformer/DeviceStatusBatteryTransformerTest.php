<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceStatusBattery;
use ChristianBrown\SmartThings\Model\DeviceStatusBatteryBatteryInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryBatteryTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusBattery::class)]
#[CoversClass(DeviceStatusBatteryTransformer::class)]
final class DeviceStatusBatteryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $batteryData = [
            DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => 42,
        ];
        $data = [
            DeviceStatusBatteryTransformerInterface::KEY_BATTERY => $batteryData,
        ];

        $battery = self::createStub(DeviceStatusBatteryBatteryInterface::class);

        $batteryTransformer = self::createMock(DeviceStatusBatteryBatteryTransformerInterface::class);
        $batteryTransformer->expects(self::once())->method('transform')
            ->with($batteryData)
            ->willReturn($battery);

        $transformer = new DeviceStatusBatteryTransformer($batteryTransformer);

        $actual = $transformer->transform($data);

        self::assertNotNull($actual);
        self::assertSame($battery, $actual->getBattery());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DeviceStatusBatteryTransformerInterface::KEY_BATTERY => 'test-not-an-array']])]
    public function testTransformUnexpectedData(array $data): void
    {
        $batteryTransformer = self::createStub(DeviceStatusBatteryBatteryTransformerInterface::class);
        $transformer = new DeviceStatusBatteryTransformer($batteryTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceStatusBatteryTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceStatusBatteryTransformerInterface::KEY_BATTERY));
        $transformer->transform($data);
    }

    public function testTransformWithoutValueReturnsNull(): void
    {
        $data = [
            DeviceStatusBatteryTransformerInterface::KEY_BATTERY => [
                DeviceStatusBatteryBatteryTransformerInterface::KEY_VALUE => null,
            ],
        ];

        $batteryTransformer = self::createStub(DeviceStatusBatteryBatteryTransformerInterface::class);
        $transformer = new DeviceStatusBatteryTransformer($batteryTransformer);

        self::assertNull($transformer->transform($data));
    }
}
