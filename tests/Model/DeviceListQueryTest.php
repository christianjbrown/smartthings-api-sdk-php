<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceListQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceListQuery::class)]
final class DeviceListQueryTest extends TestCase
{
    public function testDefaultsToNoParameters(): void
    {
        $query = new DeviceListQuery();

        self::assertNull($query->getAccessLevel());
        self::assertNull($query->getCapabilities());
        self::assertNull($query->getCapabilitiesMode());
        self::assertNull($query->getDeviceIds());
        self::assertNull($query->getIncludeAllowedActions());
        self::assertNull($query->getIncludeHealth());
        self::assertNull($query->getIncludeRestricted());
        self::assertNull($query->getIncludeStatus());
        self::assertNull($query->getLocationIds());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_ACCESS_LEVEL => null,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_CAPABILITIES_MODE => null,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_CAPABILITY => null,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_DEVICE_ID => null,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_INCLUDE_ALLOWED_ACTIONS => null,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_INCLUDE_HEALTH => null,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_INCLUDE_RESTRICTED => null,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_INCLUDE_STATUS => null,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_LOCATION_ID => null,
        ], $query->getParameters());
    }

    public function testStoresEveryParameter(): void
    {
        $query = new DeviceListQuery();
        self::assertSame($query, $query->setAccessLevel(7));
        self::assertSame($query, $query->setCapabilities(['test-capabilities-1', 'test-capabilities-2']));
        self::assertSame($query, $query->setCapabilitiesMode('test-capabilitiesMode'));
        self::assertSame($query, $query->setDeviceIds(['test-deviceIds-1', 'test-deviceIds-2']));
        self::assertSame($query, $query->setIncludeAllowedActions(true));
        self::assertSame($query, $query->setIncludeHealth(true));
        self::assertSame($query, $query->setIncludeRestricted(true));
        self::assertSame($query, $query->setIncludeStatus(true));
        self::assertSame($query, $query->setLocationIds(['test-locationIds-1', 'test-locationIds-2']));
        self::assertSame(7, $query->getAccessLevel());
        self::assertSame(['test-capabilities-1', 'test-capabilities-2'], $query->getCapabilities());
        self::assertSame('test-capabilitiesMode', $query->getCapabilitiesMode());
        self::assertSame(['test-deviceIds-1', 'test-deviceIds-2'], $query->getDeviceIds());
        self::assertTrue($query->getIncludeAllowedActions());
        self::assertTrue($query->getIncludeHealth());
        self::assertTrue($query->getIncludeRestricted());
        self::assertTrue($query->getIncludeStatus());
        self::assertSame(['test-locationIds-1', 'test-locationIds-2'], $query->getLocationIds());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_ACCESS_LEVEL => 7,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_CAPABILITIES_MODE => 'test-capabilitiesMode',
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_CAPABILITY => ['test-capabilities-1', 'test-capabilities-2'],
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_DEVICE_ID => ['test-deviceIds-1', 'test-deviceIds-2'],
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_INCLUDE_ALLOWED_ACTIONS => true,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_INCLUDE_HEALTH => true,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_INCLUDE_RESTRICTED => true,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_INCLUDE_STATUS => true,
            \ChristianBrown\SmartThings\Model\DeviceListQueryInterface::KEY_LOCATION_ID => ['test-locationIds-1', 'test-locationIds-2'],
        ], $query->getParameters());
    }
}
