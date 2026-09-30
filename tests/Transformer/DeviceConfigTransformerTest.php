<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfig;
use ChristianBrown\SmartThings\Transformer\DeviceConfigTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigTransformer::class)]
#[CoversClass(DeviceConfig::class)]
#[CoversClass(ValueReader::class)]
final class DeviceConfigTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new DeviceConfigTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getDeviceId());
        self::assertNull($actual->getComponentId());
        self::assertSame([], $actual->getPermissions());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new DeviceConfigTransformer(new ValueReader()))->transform([
            DeviceConfigTransformerInterface::KEY_DEVICE_ID => 'test-deviceId',
            DeviceConfigTransformerInterface::KEY_COMPONENT_ID => 'test-componentId',
            DeviceConfigTransformerInterface::KEY_PERMISSIONS => ['test-permissions-1', 'test-permissions-2'],
        ]);

        self::assertSame('test-deviceId', $actual->getDeviceId());
        self::assertSame('test-componentId', $actual->getComponentId());
        self::assertSame(['test-permissions-1', 'test-permissions-2'], $actual->getPermissions());
    }
}
