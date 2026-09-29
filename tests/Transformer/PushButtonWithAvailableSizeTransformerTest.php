<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PushButtonWithAvailableSize;
use ChristianBrown\SmartThings\Transformer\PushButtonWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\PushButtonWithAvailableSizeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PushButtonWithAvailableSize::class)]
#[CoversClass(PushButtonWithAvailableSizeTransformer::class)]
final class PushButtonWithAvailableSizeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PushButtonWithAvailableSizeTransformerInterface::KEY_COMMAND => 'test-command',
            PushButtonWithAvailableSizeTransformerInterface::KEY_ARGUMENT => 'test-argument',
            PushButtonWithAvailableSizeTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            PushButtonWithAvailableSizeTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            PushButtonWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
        ];

        $transformer = new PushButtonWithAvailableSizeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument', $actual->getArgument());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame(['test-available-sizes-1', 'test-available-sizes-2'], $actual->getAvailableSizes());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PushButtonWithAvailableSizeTransformer();

        $actual = $transformer->transform([PushButtonWithAvailableSizeTransformerInterface::KEY_COMMAND => 'test-command'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'argumentAbsent' => [[], 'getArgument', null];
        yield 'argumentWrongType' => [[PushButtonWithAvailableSizeTransformerInterface::KEY_ARGUMENT => 42], 'getArgument', null];
        yield 'argumentValid' => [[PushButtonWithAvailableSizeTransformerInterface::KEY_ARGUMENT => 'test-argument'], 'getArgument', 'test-argument'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[PushButtonWithAvailableSizeTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[PushButtonWithAvailableSizeTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[PushButtonWithAvailableSizeTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[PushButtonWithAvailableSizeTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
        yield 'availableSizesAbsent' => [[], 'getAvailableSizes', null];
        yield 'availableSizesWrongType' => [[PushButtonWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => 'not-array'], 'getAvailableSizes', null];
        yield 'availableSizesValid' => [[PushButtonWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2']], 'getAvailableSizes', ['test-available-sizes-1', 'test-available-sizes-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new PushButtonWithAvailableSizeTransformer();

        $actual = $transformer->transform([PushButtonWithAvailableSizeTransformerInterface::KEY_COMMAND => 'test-command']);

        self::assertNull($actual->getArgument());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getIconUrl());
        self::assertNull($actual->getAvailableSizes());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PushButtonWithAvailableSizeTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[], sprintf(PushButtonWithAvailableSizeTransformerInterface::UNEXPECTED_STRING_SPRINTF, PushButtonWithAvailableSizeTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[PushButtonWithAvailableSizeTransformerInterface::KEY_COMMAND => 42], sprintf(PushButtonWithAvailableSizeTransformerInterface::UNEXPECTED_STRING_SPRINTF, PushButtonWithAvailableSizeTransformerInterface::KEY_COMMAND)];
    }
}
