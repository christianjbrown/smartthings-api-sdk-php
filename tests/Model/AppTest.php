<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\App;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(App::class)]
final class AppTest extends TestCase
{
    public function test(): void
    {
        $app = new App('test-app-id');
        self::assertSame('test-app-id', $app->getAppId());
        self::assertNull($app->getAppName());
        self::assertNull($app->getAppType());
        self::assertNull($app->getDisplayName());

        self::assertSame($app, $app->setAppId('test-new-app-id'));
        self::assertSame($app, $app->setAppName('test-app-name'));
        self::assertSame($app, $app->setAppType('WEBHOOK_SMART_APP'));
        self::assertSame($app, $app->setDisplayName('test-display-name'));

        self::assertSame('test-new-app-id', $app->getAppId());
        self::assertSame('test-app-name', $app->getAppName());
        self::assertSame('WEBHOOK_SMART_APP', $app->getAppType());
        self::assertSame('test-display-name', $app->getDisplayName());
    }
}
