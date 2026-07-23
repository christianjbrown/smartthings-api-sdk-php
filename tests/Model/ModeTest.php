<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Mode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Mode::class)]
final class ModeTest extends TestCase
{
    public function test(): void
    {
        $mode = new Mode('test-mode-id');
        self::assertSame('test-mode-id', $mode->getId());
        self::assertNull($mode->getLabel());
        self::assertNull($mode->getName());

        self::assertSame($mode, $mode->setId('test-new-mode-id'));
        self::assertSame($mode, $mode->setLabel('test-label'));
        self::assertSame($mode, $mode->setName('test-name'));

        self::assertSame('test-new-mode-id', $mode->getId());
        self::assertSame('test-label', $mode->getLabel());
        self::assertSame('test-name', $mode->getName());
    }
}
