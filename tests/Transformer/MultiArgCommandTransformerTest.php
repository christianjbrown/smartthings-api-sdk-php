<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\MultiArgCommand;
use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItemInterface;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandArgumentsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandTransformer;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MultiArgCommand::class)]
#[CoversClass(MultiArgCommandTransformer::class)]
final class MultiArgCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $multiArgCommandArgumentsItemModel = self::createStub(MultiArgCommandArgumentsItemInterface::class);
        $multiArgCommandArgumentsItemTransformer = self::createStub(MultiArgCommandArgumentsItemTransformerInterface::class);
        $multiArgCommandArgumentsItemTransformer->method('transform')->willReturn($multiArgCommandArgumentsItemModel);
        $data = [
            MultiArgCommandTransformerInterface::KEY_COMMAND => 'test-command',
            MultiArgCommandTransformerInterface::KEY_ARGUMENTS => [['test-nested']],
            MultiArgCommandTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
        ];

        $transformer = new MultiArgCommandTransformer($multiArgCommandArgumentsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame([$multiArgCommandArgumentsItemModel], $actual->getArguments());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new MultiArgCommandTransformer(self::createStub(MultiArgCommandArgumentsItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[MultiArgCommandTransformerInterface::KEY_ARGUMENTS => ['test-nested']], 'getCommand', null];
        yield 'commandWrongType' => [[MultiArgCommandTransformerInterface::KEY_ARGUMENTS => ['test-nested'], MultiArgCommandTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
        yield 'argumentsAbsent' => [[MultiArgCommandTransformerInterface::KEY_COMMAND => 'test-command'], 'getArguments', []];
        yield 'argumentsWrongType' => [[MultiArgCommandTransformerInterface::KEY_COMMAND => 'test-command', MultiArgCommandTransformerInterface::KEY_ARGUMENTS => 'not-array'], 'getArguments', []];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new MultiArgCommandTransformer(self::createStub(MultiArgCommandArgumentsItemTransformerInterface::class));

        $actual = $transformer->transform([MultiArgCommandTransformerInterface::KEY_COMMAND => 'test-command', MultiArgCommandTransformerInterface::KEY_ARGUMENTS => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[MultiArgCommandTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[MultiArgCommandTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $multiArgCommandArgumentsItemModel = self::createStub(MultiArgCommandArgumentsItemInterface::class);
        $multiArgCommandArgumentsItemTransformer = self::createStub(MultiArgCommandArgumentsItemTransformerInterface::class);
        $multiArgCommandArgumentsItemTransformer->method('transform')->willReturn($multiArgCommandArgumentsItemModel);
        $transformer = new MultiArgCommandTransformer($multiArgCommandArgumentsItemTransformer);

        $actual = $transformer->transform([MultiArgCommandTransformerInterface::KEY_COMMAND => 'test-command', MultiArgCommandTransformerInterface::KEY_ARGUMENTS => ['test-nested']]);

        self::assertNull($actual->getSupportedValues());
    }
}
