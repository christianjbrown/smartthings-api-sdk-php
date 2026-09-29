<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\Device;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Device::class)]
#[CoversClass(DeviceTransformer::class)]
final class DeviceTransformerRecursiveTest extends TestCase
{
    public function testTransformChildDevices(): void
    {
        $transformer = new DeviceTransformer(self::createStub(DeviceComponentsTransformerInterface::class), self::createStub(DeviceDetailsTransformerInterface::class));
        $base = [DeviceTransformerInterface::KEY_DEVICE_ID => 'test-device-id'];

        $actual = $transformer->transform($base + [DeviceTransformerInterface::KEY_CHILD_DEVICES => [$base, 'test-not-array', $base]]);

        self::assertCount(2, $actual->getChildDevices());
    }

    public function testTransformChildDevicesAbsentOrWrongType(): void
    {
        $transformer = new DeviceTransformer(self::createStub(DeviceComponentsTransformerInterface::class), self::createStub(DeviceDetailsTransformerInterface::class));
        $base = [DeviceTransformerInterface::KEY_DEVICE_ID => 'test-device-id'];

        self::assertSame([], $transformer->transform($base)->getChildDevices());
        self::assertSame([], $transformer->transform($base + [DeviceTransformerInterface::KEY_CHILD_DEVICES => 'test-not-array'])->getChildDevices());
    }
}
