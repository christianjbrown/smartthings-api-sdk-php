<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationAction;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DynamicListForAutomationAction::class)]
#[CoversClass(DynamicListForAutomationActionTransformer::class)]
final class DynamicListForAutomationActionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListTransformer = self::createStub(SupportedValuesForDynamicListTransformerInterface::class);
        $supportedValuesForDynamicListTransformer->method('transform')->willReturn($supportedValuesForDynamicListModel);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            DynamicListForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command',
            DynamicListForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            DynamicListForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested'],
            DynamicListForAutomationActionTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new DynamicListForAutomationActionTransformer($supportedValuesForDynamicListTransformer, $alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame($supportedValuesForDynamicListModel, $actual->getSupportedValues());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
    }

    public function testTransformAlternatives(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListTransformer = self::createStub(SupportedValuesForDynamicListTransformerInterface::class);
        $supportedValuesForDynamicListTransformer->method('transform')->willReturn($supportedValuesForDynamicListModel);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new DynamicListForAutomationActionTransformer($supportedValuesForDynamicListTransformer, $alternativeItemTransformer);
        $base = [DynamicListForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested']];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [DynamicListForAutomationActionTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [DynamicListForAutomationActionTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DynamicListForAutomationActionTransformer(self::createStub(SupportedValuesForDynamicListTransformerInterface::class), self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([DynamicListForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'commandAbsent' => [[], 'getCommand', null];
        yield 'commandWrongType' => [[DynamicListForAutomationActionTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
        yield 'commandValid' => [[DynamicListForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command'], 'getCommand', 'test-command'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[DynamicListForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[DynamicListForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListTransformer = self::createStub(SupportedValuesForDynamicListTransformerInterface::class);
        $supportedValuesForDynamicListTransformer->method('transform')->willReturn($supportedValuesForDynamicListModel);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new DynamicListForAutomationActionTransformer($supportedValuesForDynamicListTransformer, $alternativeItemTransformer);

        $actual = $transformer->transform([DynamicListForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested']]);

        self::assertNull($actual->getCommand());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DynamicListForAutomationActionTransformer(self::createStub(SupportedValuesForDynamicListTransformerInterface::class), self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'supportedValuesAbsent' => [[], sprintf(DynamicListForAutomationActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DynamicListForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES)];
        yield 'supportedValuesWrongType' => [[DynamicListForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => 'not-array'], sprintf(DynamicListForAutomationActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DynamicListForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES)];
    }
}
