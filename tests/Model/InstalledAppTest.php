<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\InstalledApp;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledApp::class)]
final class InstalledAppTest extends TestCase
{
    public function test(): void
    {
        $installedApp = new InstalledApp('test-installed-app-id');
        self::assertSame('test-installed-app-id', $installedApp->getInstalledAppId());
        self::assertNull($installedApp->getAppId());
        self::assertNull($installedApp->getDisplayName());
        self::assertNull($installedApp->getInstalledAppStatus());
        self::assertNull($installedApp->getInstalledAppType());
        self::assertNull($installedApp->getLocationId());

        self::assertSame($installedApp, $installedApp->setInstalledAppId('test-new-installed-app-id'));
        self::assertSame($installedApp, $installedApp->setAppId('test-app-id'));
        self::assertSame($installedApp, $installedApp->setDisplayName('test-display-name'));
        self::assertSame($installedApp, $installedApp->setInstalledAppStatus('AUTHORIZED'));
        self::assertSame($installedApp, $installedApp->setInstalledAppType('WEBHOOK_SMART_APP'));
        self::assertSame($installedApp, $installedApp->setLocationId('test-location-id'));

        self::assertSame('test-new-installed-app-id', $installedApp->getInstalledAppId());
        self::assertSame('test-app-id', $installedApp->getAppId());
        self::assertSame('test-display-name', $installedApp->getDisplayName());
        self::assertSame('AUTHORIZED', $installedApp->getInstalledAppStatus());
        self::assertSame('WEBHOOK_SMART_APP', $installedApp->getInstalledAppType());
        self::assertSame('test-location-id', $installedApp->getLocationId());
    }
}
