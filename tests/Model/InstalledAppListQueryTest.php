<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\InstalledAppListQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledAppListQuery::class)]
final class InstalledAppListQueryTest extends TestCase
{
    public function testDefaultsToNoParameters(): void
    {
        $query = new InstalledAppListQuery();

        self::assertNull($query->getAppId());
        self::assertNull($query->getDeviceId());
        self::assertNull($query->getInstalledAppStatus());
        self::assertNull($query->getInstalledAppType());
        self::assertNull($query->getLocationId());
        self::assertNull($query->getModeId());
        self::assertNull($query->getTag());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_APP_ID => null,
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_DEVICE_ID => null,
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_INSTALLED_APP_STATUS => null,
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_INSTALLED_APP_TYPE => null,
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_LOCATION_ID => null,
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_MODE_ID => null,
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_TAG => null,
        ], $query->getParameters());
    }

    public function testStoresEveryParameter(): void
    {
        $query = new InstalledAppListQuery();
        self::assertSame($query, $query->setAppId('test-appId'));
        self::assertSame($query, $query->setDeviceId('test-deviceId'));
        self::assertSame($query, $query->setInstalledAppStatus('test-installedAppStatus'));
        self::assertSame($query, $query->setInstalledAppType('test-installedAppType'));
        self::assertSame($query, $query->setLocationId('test-locationId'));
        self::assertSame($query, $query->setModeId('test-modeId'));
        self::assertSame($query, $query->setTag('test-tag'));
        self::assertSame('test-appId', $query->getAppId());
        self::assertSame('test-deviceId', $query->getDeviceId());
        self::assertSame('test-installedAppStatus', $query->getInstalledAppStatus());
        self::assertSame('test-installedAppType', $query->getInstalledAppType());
        self::assertSame('test-locationId', $query->getLocationId());
        self::assertSame('test-modeId', $query->getModeId());
        self::assertSame('test-tag', $query->getTag());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_APP_ID => 'test-appId',
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_DEVICE_ID => 'test-deviceId',
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_INSTALLED_APP_STATUS => 'test-installedAppStatus',
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_INSTALLED_APP_TYPE => 'test-installedAppType',
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_LOCATION_ID => 'test-locationId',
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_MODE_ID => 'test-modeId',
            \ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface::KEY_TAG => 'test-tag',
        ], $query->getParameters());
    }
}
