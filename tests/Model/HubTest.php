<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Hub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hub::class)]
final class HubTest extends TestCase
{
    public function test(): void
    {
        $hub = new Hub('test-hub-id');
        self::assertSame('test-hub-id', $hub->getId());
        self::assertNull($hub->getEui());
        self::assertNull($hub->getFirmwareVersion());
        self::assertNull($hub->getName());
        self::assertNull($hub->getOwner());
        self::assertNull($hub->getSerialNumber());

        self::assertSame($hub, $hub->setId('test-new-hub-id'));
        self::assertSame($hub, $hub->setEui('test-eui'));
        self::assertSame($hub, $hub->setFirmwareVersion('1.2.3'));
        self::assertSame($hub, $hub->setName('Home Hub'));
        self::assertSame($hub, $hub->setOwner('test-owner'));
        self::assertSame($hub, $hub->setSerialNumber('test-serial'));

        self::assertSame('test-new-hub-id', $hub->getId());
        self::assertSame('test-eui', $hub->getEui());
        self::assertSame('1.2.3', $hub->getFirmwareVersion());
        self::assertSame('Home Hub', $hub->getName());
        self::assertSame('test-owner', $hub->getOwner());
        self::assertSame('test-serial', $hub->getSerialNumber());
    }
}
