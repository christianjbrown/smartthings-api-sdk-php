<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PushButton;
use ChristianBrown\SmartThings\Transformer\PushButtonTransformer;
use ChristianBrown\SmartThings\Transformer\PushButtonTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PushButton::class)]
#[CoversClass(PushButtonTransformer::class)]
final class PushButtonTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PushButtonTransformerInterface::KEY_COMMAND => 'test-command',
            PushButtonTransformerInterface::KEY_ARGUMENT => 'test-argument',
            PushButtonTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
        ];

        $transformer = new PushButtonTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument', $actual->getArgument());
        self::assertSame('test-argument-type', $actual->getArgumentType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PushButtonTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[], 'getCommand', null];
        yield 'commandWrongType' => [[PushButtonTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PushButtonTransformer();

        $actual = $transformer->transform([PushButtonTransformerInterface::KEY_COMMAND => 'test-command'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'argumentAbsent' => [[], 'getArgument', null];
        yield 'argumentWrongType' => [[PushButtonTransformerInterface::KEY_ARGUMENT => 42], 'getArgument', null];
        yield 'argumentValid' => [[PushButtonTransformerInterface::KEY_ARGUMENT => 'test-argument'], 'getArgument', 'test-argument'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[PushButtonTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[PushButtonTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new PushButtonTransformer();

        $actual = $transformer->transform([PushButtonTransformerInterface::KEY_COMMAND => 'test-command']);

        self::assertNull($actual->getArgument());
        self::assertNull($actual->getArgumentType());
    }
}
