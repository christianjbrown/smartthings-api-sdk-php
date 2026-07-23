<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\HubInstalledDriver;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubInstalledDriver::class)]
final class HubInstalledDriverTest extends TestCase
{
    public function test(): void
    {
        $driver = new HubInstalledDriver('test-driver-id');
        self::assertSame('test-driver-id', $driver->getDriverId());
        self::assertNull($driver->getChannelId());
        self::assertNull($driver->getDescription());
        self::assertNull($driver->getDeveloper());
        self::assertNull($driver->getName());
        self::assertNull($driver->getVendorSupportInformation());
        self::assertNull($driver->getVersion());

        self::assertSame($driver, $driver->setDriverId('test-new-driver-id'));
        self::assertSame($driver, $driver->setChannelId('test-channel-id'));
        self::assertSame($driver, $driver->setDescription('Test description'));
        self::assertSame($driver, $driver->setDeveloper('Test Developer'));
        self::assertSame($driver, $driver->setName('Test Driver'));
        self::assertSame($driver, $driver->setVendorSupportInformation('support@example.com'));
        self::assertSame($driver, $driver->setVersion('2024-01-01'));

        self::assertSame('test-new-driver-id', $driver->getDriverId());
        self::assertSame('test-channel-id', $driver->getChannelId());
        self::assertSame('Test description', $driver->getDescription());
        self::assertSame('Test Developer', $driver->getDeveloper());
        self::assertSame('Test Driver', $driver->getName());
        self::assertSame('support@example.com', $driver->getVendorSupportInformation());
        self::assertSame('2024-01-01', $driver->getVersion());
    }
}
