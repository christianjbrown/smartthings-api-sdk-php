<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\CapabilityNamespace;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityNamespace::class)]
final class CapabilityNamespaceTest extends TestCase
{
    public function test(): void
    {
        $namespace = new CapabilityNamespace('test-namespace');
        self::assertSame('test-namespace', $namespace->getName());
        self::assertNull($namespace->getOwnerId());
        self::assertNull($namespace->getOwnerType());

        self::assertSame($namespace, $namespace->setName('test-new-namespace'));
        self::assertSame($namespace, $namespace->setOwnerId('test-owner-id'));
        self::assertSame($namespace, $namespace->setOwnerType('USER'));

        self::assertSame('test-new-namespace', $namespace->getName());
        self::assertSame('test-owner-id', $namespace->getOwnerId());
        self::assertSame('USER', $namespace->getOwnerType());
    }
}
