<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationAction;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationActionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(NumberFieldForAutomationAction::class)]
#[CoversClass(NumberFieldForAutomationActionTransformer::class)]
final class NumberFieldForAutomationActionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            NumberFieldForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command',
            NumberFieldForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            NumberFieldForAutomationActionTransformerInterface::KEY_UNIT => 'test-unit',
            NumberFieldForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            NumberFieldForAutomationActionTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            NumberFieldForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            NumberFieldForAutomationActionTransformerInterface::KEY_DESCRIPTION => 'test-description',
        ];

        $transformer = new NumberFieldForAutomationActionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame('test-description', $actual->getDescription());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new NumberFieldForAutomationActionTransformer($alternativeItemTransformer);
        $base = [NumberFieldForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [NumberFieldForAutomationActionTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [NumberFieldForAutomationActionTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new NumberFieldForAutomationActionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([NumberFieldForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[NumberFieldForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[NumberFieldForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[NumberFieldForAutomationActionTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[NumberFieldForAutomationActionTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[NumberFieldForAutomationActionTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[NumberFieldForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[NumberFieldForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[NumberFieldForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[NumberFieldForAutomationActionTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[NumberFieldForAutomationActionTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new NumberFieldForAutomationActionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([NumberFieldForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command']);

        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getRange());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getDescription());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new NumberFieldForAutomationActionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[], sprintf(NumberFieldForAutomationActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, NumberFieldForAutomationActionTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[NumberFieldForAutomationActionTransformerInterface::KEY_COMMAND => 42], sprintf(NumberFieldForAutomationActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, NumberFieldForAutomationActionTransformerInterface::KEY_COMMAND)];
    }
}
