<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\InstalledAppConfig;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledAppConfig::class)]
final class InstalledAppConfigTest extends TestCase
{
    public function test(): void
    {
        $config = new InstalledAppConfig('test-configuration-id');
        self::assertSame('test-configuration-id', $config->getConfigurationId());
        self::assertNull($config->getConfigurationStatus());
        self::assertNull($config->getInstalledAppId());

        self::assertSame($config, $config->setConfigurationId('test-new-configuration-id'));
        self::assertSame($config, $config->setConfigurationStatus('DONE'));
        self::assertSame($config, $config->setInstalledAppId('test-installed-app-id'));

        self::assertSame('test-new-configuration-id', $config->getConfigurationId());
        self::assertSame('DONE', $config->getConfigurationStatus());
        self::assertSame('test-installed-app-id', $config->getInstalledAppId());
    }
}
