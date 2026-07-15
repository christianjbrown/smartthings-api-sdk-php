<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Device;
use ChristianBrown\SmartThings\Model\DeviceComponentInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Device::class)]
final class DeviceTest extends TestCase
{
    public function test(): void
    {
        $device = new Device('test-device-id');
        self::assertSame('test-device-id', $device->getDeviceId());
        self::assertNull($device->getName());
        self::assertNull($device->getLabel());
        self::assertEmpty($device->getComponents());

        self::assertSame($device, $device->setDeviceId('test-new-device-id'));
        self::assertSame($device, $device->setLabel('test-label'));
        self::assertSame($device, $device->setName('test-name'));
        $components = [
            self::createStub(DeviceComponentInterface::class),
            self::createStub(DeviceComponentInterface::class),
        ];
        self::assertSame($device, $device->setComponents($components));

        self::assertSame('test-new-device-id', $device->getDeviceId());
        self::assertSame('test-label', $device->getLabel());
        self::assertSame('test-name', $device->getName());
        self::assertSame($components, $device->getComponents());
    }
}
