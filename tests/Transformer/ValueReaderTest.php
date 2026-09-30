<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ValueReader::class)]
final class ValueReaderTest extends TestCase
{
    public function testReadsABool(): void
    {
        $reader = new ValueReader();

        self::assertTrue($reader->bool(['k' => true], 'k'));
        self::assertFalse($reader->bool(['k' => false], 'k'));
        self::assertNull($reader->bool(['k' => 'true'], 'k'));
        self::assertNull($reader->bool([], 'k'));
    }

    public function testReadsAnInt(): void
    {
        $reader = new ValueReader();

        self::assertSame(0, $reader->int(['k' => 0], 'k'));
        self::assertNull($reader->int(['k' => '1'], 'k'));
        self::assertNull($reader->int([], 'k'));
    }

    public function testReadsARecord(): void
    {
        $reader = new ValueReader();

        self::assertSame(['a' => 1], $reader->record(['k' => ['a' => 1]], 'k'));
        self::assertNull($reader->record(['k' => 'x'], 'k'));
        self::assertNull($reader->record([], 'k'));
    }

    public function testReadsAString(): void
    {
        $reader = new ValueReader();

        self::assertSame('', $reader->string(['k' => ''], 'k'));
        self::assertNull($reader->string(['k' => 1], 'k'));
        self::assertNull($reader->string([], 'k'));
    }

    public function testReadsTheArrayEntriesOfAList(): void
    {
        $reader = new ValueReader();

        self::assertSame([['a' => 1], ['b' => 2]], $reader->records(['k' => [['a' => 1], 'skipped', 3 => ['b' => 2]]], 'k'));
        self::assertSame([], $reader->records(['k' => 'x'], 'k'));
        self::assertSame([], $reader->records([], 'k'));
    }
}
