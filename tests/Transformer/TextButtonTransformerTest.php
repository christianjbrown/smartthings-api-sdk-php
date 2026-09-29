<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\TextButton;
use ChristianBrown\SmartThings\Model\TextButtonButtonsItemInterface;
use ChristianBrown\SmartThings\Transformer\TextButtonButtonsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TextButtonTransformer;
use ChristianBrown\SmartThings\Transformer\TextButtonTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TextButton::class)]
#[CoversClass(TextButtonTransformer::class)]
final class TextButtonTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $textButtonButtonsItemModel = self::createStub(TextButtonButtonsItemInterface::class);
        $textButtonButtonsItemTransformer = self::createStub(TextButtonButtonsItemTransformerInterface::class);
        $textButtonButtonsItemTransformer->method('transform')->willReturn($textButtonButtonsItemModel);
        $data = [
            TextButtonTransformerInterface::KEY_COMMAND => 'test-command',
            TextButtonTransformerInterface::KEY_VALUE => 'test-value',
            TextButtonTransformerInterface::KEY_BUTTONS => [['test-nested']],
            TextButtonTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
        ];

        $transformer = new TextButtonTransformer($textButtonButtonsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame([$textButtonButtonsItemModel], $actual->getButtons());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new TextButtonTransformer(self::createStub(TextButtonButtonsItemTransformerInterface::class));

        $actual = $transformer->transform([TextButtonTransformerInterface::KEY_BUTTONS => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'commandAbsent' => [[], 'getCommand', null];
        yield 'commandWrongType' => [[TextButtonTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
        yield 'commandValid' => [[TextButtonTransformerInterface::KEY_COMMAND => 'test-command'], 'getCommand', 'test-command'];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[TextButtonTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[TextButtonTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[TextButtonTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[TextButtonTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $textButtonButtonsItemModel = self::createStub(TextButtonButtonsItemInterface::class);
        $textButtonButtonsItemTransformer = self::createStub(TextButtonButtonsItemTransformerInterface::class);
        $textButtonButtonsItemTransformer->method('transform')->willReturn($textButtonButtonsItemModel);
        $transformer = new TextButtonTransformer($textButtonButtonsItemTransformer);

        $actual = $transformer->transform([TextButtonTransformerInterface::KEY_BUTTONS => ['test-nested']]);

        self::assertNull($actual->getCommand());
        self::assertNull($actual->getValue());
        self::assertNull($actual->getSupportedValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new TextButtonTransformer(self::createStub(TextButtonButtonsItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'buttonsAbsent' => [[], sprintf(TextButtonTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, TextButtonTransformerInterface::KEY_BUTTONS)];
        yield 'buttonsWrongType' => [[TextButtonTransformerInterface::KEY_BUTTONS => 'not-array'], sprintf(TextButtonTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, TextButtonTransformerInterface::KEY_BUTTONS)];
    }
}
