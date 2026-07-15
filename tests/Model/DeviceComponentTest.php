<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceComponent;
use ChristianBrown\SmartThings\Model\DeviceComponentCapabilityInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceComponent::class)]
final class DeviceComponentTest extends TestCase
{
    public function test(): void
    {
        $deviceComponent = new DeviceComponent();
        self::assertEmpty($deviceComponent->getCapabilities());
        $capabilities = [
            self::createStub(DeviceComponentCapabilityInterface::class),
            self::createStub(DeviceComponentCapabilityInterface::class),
        ];
        self::assertSame($deviceComponent, $deviceComponent->setCapabilities($capabilities));
        self::assertSame($capabilities, $deviceComponent->getCapabilities());
    }
}
