<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Capability;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Capability::class)]
final class CapabilityTest extends TestCase
{
    public function test(): void
    {
        $capability = new Capability('test-capability-id');
        self::assertSame('test-capability-id', $capability->getId());
        self::assertNull($capability->getName());
        self::assertNull($capability->getStatus());
        self::assertNull($capability->getVersion());

        self::assertSame($capability, $capability->setId('test-new-capability-id'));
        self::assertSame($capability, $capability->setName('test-name'));
        self::assertSame($capability, $capability->setStatus('live'));
        self::assertSame($capability, $capability->setVersion(1));

        self::assertSame('test-new-capability-id', $capability->getId());
        self::assertSame('test-name', $capability->getName());
        self::assertSame('live', $capability->getStatus());
        self::assertSame(1, $capability->getVersion());
    }
}
