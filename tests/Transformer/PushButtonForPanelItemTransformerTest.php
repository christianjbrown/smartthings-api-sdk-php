<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PushButtonForPanelItem;
use ChristianBrown\SmartThings\Transformer\PushButtonForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\PushButtonForPanelItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PushButtonForPanelItem::class)]
#[CoversClass(PushButtonForPanelItemTransformer::class)]
final class PushButtonForPanelItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PushButtonForPanelItemTransformerInterface::KEY_COMMAND => 'test-command',
            PushButtonForPanelItemTransformerInterface::KEY_ARGUMENT => 'test-argument',
            PushButtonForPanelItemTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            PushButtonForPanelItemTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            PushButtonForPanelItemTransformerInterface::KEY_SIZE => 'test-size',
        ];

        $transformer = new PushButtonForPanelItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument', $actual->getArgument());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame('test-size', $actual->getSize());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PushButtonForPanelItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[PushButtonForPanelItemTransformerInterface::KEY_SIZE => 'test-size'], 'getCommand', null];
        yield 'commandWrongType' => [[PushButtonForPanelItemTransformerInterface::KEY_SIZE => 'test-size', PushButtonForPanelItemTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
        yield 'sizeAbsent' => [[PushButtonForPanelItemTransformerInterface::KEY_COMMAND => 'test-command'], 'getSize', null];
        yield 'sizeWrongType' => [[PushButtonForPanelItemTransformerInterface::KEY_COMMAND => 'test-command', PushButtonForPanelItemTransformerInterface::KEY_SIZE => 42], 'getSize', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PushButtonForPanelItemTransformer();

        $actual = $transformer->transform([PushButtonForPanelItemTransformerInterface::KEY_COMMAND => 'test-command', PushButtonForPanelItemTransformerInterface::KEY_SIZE => 'test-size'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'argumentAbsent' => [[], 'getArgument', null];
        yield 'argumentWrongType' => [[PushButtonForPanelItemTransformerInterface::KEY_ARGUMENT => 42], 'getArgument', null];
        yield 'argumentValid' => [[PushButtonForPanelItemTransformerInterface::KEY_ARGUMENT => 'test-argument'], 'getArgument', 'test-argument'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[PushButtonForPanelItemTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[PushButtonForPanelItemTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[PushButtonForPanelItemTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[PushButtonForPanelItemTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new PushButtonForPanelItemTransformer();

        $actual = $transformer->transform([PushButtonForPanelItemTransformerInterface::KEY_COMMAND => 'test-command', PushButtonForPanelItemTransformerInterface::KEY_SIZE => 'test-size']);

        self::assertNull($actual->getArgument());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getIconUrl());
    }
}
