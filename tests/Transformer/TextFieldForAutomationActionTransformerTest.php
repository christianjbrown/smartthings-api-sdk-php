<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationAction;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationActionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextFieldForAutomationAction::class)]
#[CoversClass(TextFieldForAutomationActionTransformer::class)]
final class TextFieldForAutomationActionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TextFieldForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command',
            TextFieldForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            TextFieldForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
        ];

        $transformer = new TextFieldForAutomationActionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new TextFieldForAutomationActionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[], 'getCommand', null];
        yield 'commandWrongType' => [[TextFieldForAutomationActionTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new TextFieldForAutomationActionTransformer();

        $actual = $transformer->transform([TextFieldForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[TextFieldForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[TextFieldForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[TextFieldForAutomationActionTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[TextFieldForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new TextFieldForAutomationActionTransformer();

        $actual = $transformer->transform([TextFieldForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command']);

        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getRange());
    }
}
