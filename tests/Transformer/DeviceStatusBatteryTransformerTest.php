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
        $data = [
            DeviceStatusBatteryTransformerInterface::KEY_BATTERY => ['test-battery'],
        ];

        $battery = self::createStub(DeviceStatusBatteryBatteryInterface::class);

        $batteryTransformer = self::createMock(DeviceStatusBatteryBatteryTransformerInterface::class);
        $batteryTransformer->method('transform')
            ->with(['test-battery'])
            ->willReturn($battery);

        $transformer = new DeviceStatusBatteryTransformer($batteryTransformer);

        $actual = $transformer->transform($data);

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
}
