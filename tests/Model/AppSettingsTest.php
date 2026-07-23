<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\AppSettings;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppSettings::class)]
final class AppSettingsTest extends TestCase
{
    public function test(): void
    {
        $settings = new AppSettings();
        self::assertSame([], $settings->getSettings());

        self::assertSame($settings, $settings->setSettings(['key' => 'value']));

        self::assertSame(['key' => 'value'], $settings->getSettings());
    }
}
