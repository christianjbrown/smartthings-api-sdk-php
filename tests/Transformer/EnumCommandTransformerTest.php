<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\EnumCommand;
use ChristianBrown\SmartThings\Transformer\EnumCommandTransformer;
use ChristianBrown\SmartThings\Transformer\EnumCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EnumCommand::class)]
#[CoversClass(EnumCommandTransformer::class)]
final class EnumCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EnumCommandTransformerInterface::KEY_COMMAND => 'test-command',
            EnumCommandTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new EnumCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new EnumCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[EnumCommandTransformerInterface::KEY_VALUE => 'test-value'], 'getCommand', null];
        yield 'commandWrongType' => [[EnumCommandTransformerInterface::KEY_VALUE => 'test-value', EnumCommandTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
        yield 'valueAbsent' => [[EnumCommandTransformerInterface::KEY_COMMAND => 'test-command'], 'getValue', null];
        yield 'valueWrongType' => [[EnumCommandTransformerInterface::KEY_COMMAND => 'test-command', EnumCommandTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }
}
