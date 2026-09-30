<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemId;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedConditionItemId::class)]
#[CoversClass(ExcludedConditionItemIdTransformer::class)]
final class ExcludedConditionItemIdTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $excludedConditionItemIdExcludeItemModel = self::createStub(ExcludedConditionItemIdExcludeItemInterface::class);
        $excludedConditionItemIdExcludeItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemModel);
        $data = [
            ExcludedConditionItemIdTransformerInterface::KEY_ID => 7,
            ExcludedConditionItemIdTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
            ExcludedConditionItemIdTransformerInterface::KEY_EXCLUDE => [['test-nested']],
        ];

        $transformer = new ExcludedConditionItemIdTransformer($excludedConditionItemIdExcludeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(7, $actual->getId());
        self::assertSame(['test-value-key' => 'test-value'], $actual->getValue());
        self::assertSame([$excludedConditionItemIdExcludeItemModel], $actual->getExclude());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedConditionItemIdTransformer(self::createStub(ExcludedConditionItemIdExcludeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'excludeAbsent' => [[], 'getExclude', []];
        yield 'excludeWrongType' => [[ExcludedConditionItemIdTransformerInterface::KEY_EXCLUDE => 'not-array'], 'getExclude', []];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedConditionItemIdTransformer(self::createStub(ExcludedConditionItemIdExcludeItemTransformerInterface::class));

        $actual = $transformer->transform([ExcludedConditionItemIdTransformerInterface::KEY_EXCLUDE => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'idAbsent' => [[], 'getId', null];
        yield 'idWrongType' => [[ExcludedConditionItemIdTransformerInterface::KEY_ID => 'not-int'], 'getId', null];
        yield 'idValid' => [[ExcludedConditionItemIdTransformerInterface::KEY_ID => 7], 'getId', 7];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[ExcludedConditionItemIdTransformerInterface::KEY_VALUE => 'not-array'], 'getValue', null];
        yield 'valueValid' => [[ExcludedConditionItemIdTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value']], 'getValue', ['test-value-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $excludedConditionItemIdExcludeItemModel = self::createStub(ExcludedConditionItemIdExcludeItemInterface::class);
        $excludedConditionItemIdExcludeItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemModel);
        $transformer = new ExcludedConditionItemIdTransformer($excludedConditionItemIdExcludeItemTransformer);

        $actual = $transformer->transform([ExcludedConditionItemIdTransformerInterface::KEY_EXCLUDE => ['test-nested']]);

        self::assertNull($actual->getId());
        self::assertNull($actual->getValue());
    }
}
