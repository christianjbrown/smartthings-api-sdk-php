<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Driver;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Driver::class)]
final class DriverTest extends TestCase
{
    public function test(): void
    {
        $driver = new Driver('test-driver-id');
        self::assertSame('test-driver-id', $driver->getDriverId());
        self::assertNull($driver->getDescription());
        self::assertNull($driver->getName());
        self::assertNull($driver->getPackageKey());
        self::assertNull($driver->getVersion());

        self::assertSame($driver, $driver->setDriverId('test-new-driver-id'));
        self::assertSame($driver, $driver->setDescription('Test description'));
        self::assertSame($driver, $driver->setName('Test Driver'));
        self::assertSame($driver, $driver->setPackageKey('test-package-key'));
        self::assertSame($driver, $driver->setVersion('2024-01-01T00:00:00.000000000'));

        self::assertSame('test-new-driver-id', $driver->getDriverId());
        self::assertSame('Test description', $driver->getDescription());
        self::assertSame('Test Driver', $driver->getName());
        self::assertSame('test-package-key', $driver->getPackageKey());
        self::assertSame('2024-01-01T00:00:00.000000000', $driver->getVersion());
    }
}
