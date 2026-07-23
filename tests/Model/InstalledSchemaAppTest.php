<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\InstalledSchemaApp;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledSchemaApp::class)]
final class InstalledSchemaAppTest extends TestCase
{
    public function test(): void
    {
        $app = new InstalledSchemaApp('test-isa-id');
        self::assertSame('test-isa-id', $app->getIsaId());
        self::assertNull($app->getAppName());
        self::assertNull($app->getLocationId());
        self::assertNull($app->getOAuthLink());
        self::assertNull($app->getPageType());
        self::assertNull($app->getPartnerName());

        self::assertSame($app, $app->setIsaId('test-new-isa-id'));
        self::assertSame($app, $app->setAppName('Lifx (Connect)'));
        self::assertSame($app, $app->setLocationId('test-location-id'));
        self::assertSame($app, $app->setOAuthLink('https://example.com/oauth'));
        self::assertSame($app, $app->setPageType('loggedIn'));
        self::assertSame($app, $app->setPartnerName('LIFX Inc.'));

        self::assertSame('test-new-isa-id', $app->getIsaId());
        self::assertSame('Lifx (Connect)', $app->getAppName());
        self::assertSame('test-location-id', $app->getLocationId());
        self::assertSame('https://example.com/oauth', $app->getOAuthLink());
        self::assertSame('loggedIn', $app->getPageType());
        self::assertSame('LIFX Inc.', $app->getPartnerName());
    }
}
