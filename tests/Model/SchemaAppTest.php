<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\SchemaApp;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaApp::class)]
final class SchemaAppTest extends TestCase
{
    public function test(): void
    {
        $app = new SchemaApp('test-endpoint-app-id');
        self::assertSame('test-endpoint-app-id', $app->getEndpointAppId());
        self::assertNull($app->getAppName());
        self::assertNull($app->getCertificationStatus());
        self::assertNull($app->getPartnerName());
        self::assertNull($app->getStClientId());

        self::assertSame($app, $app->setEndpointAppId('test-new-endpoint-app-id'));
        self::assertSame($app, $app->setAppName('Lifx (Connect)'));
        self::assertSame($app, $app->setCertificationStatus('wwst'));
        self::assertSame($app, $app->setPartnerName('LIFX Inc.'));
        self::assertSame($app, $app->setStClientId('test-client-id'));

        self::assertSame('test-new-endpoint-app-id', $app->getEndpointAppId());
        self::assertSame('Lifx (Connect)', $app->getAppName());
        self::assertSame('wwst', $app->getCertificationStatus());
        self::assertSame('LIFX Inc.', $app->getPartnerName());
        self::assertSame('test-client-id', $app->getStClientId());
    }
}
