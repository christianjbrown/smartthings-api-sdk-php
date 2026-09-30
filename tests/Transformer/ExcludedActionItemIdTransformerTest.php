<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ExcludedActionItemId;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdExcludeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedActionItemId::class)]
#[CoversClass(ExcludedActionItemIdTransformer::class)]
final class ExcludedActionItemIdTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $excludedActionItemIdExcludeItemModel = self::createStub(ExcludedActionItemIdExcludeItemInterface::class);
        $excludedActionItemIdExcludeItemTransformer = self::createStub(ExcludedActionItemIdExcludeItemTransformerInterface::class);
        $excludedActionItemIdExcludeItemTransformer->method('transform')->willReturn($excludedActionItemIdExcludeItemModel);
        $data = [
            ExcludedActionItemIdTransformerInterface::KEY_ID => 7,
            ExcludedActionItemIdTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
            ExcludedActionItemIdTransformerInterface::KEY_EXCLUDE => [['test-nested']],
        ];

        $transformer = new ExcludedActionItemIdTransformer($excludedActionItemIdExcludeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(7, $actual->getId());
        self::assertSame(['test-value-key' => 'test-value'], $actual->getValue());
        self::assertSame([$excludedActionItemIdExcludeItemModel], $actual->getExclude());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedActionItemIdTransformer(self::createStub(ExcludedActionItemIdExcludeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'excludeAbsent' => [[], 'getExclude', []];
        yield 'excludeWrongType' => [[ExcludedActionItemIdTransformerInterface::KEY_EXCLUDE => 'not-array'], 'getExclude', []];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedActionItemIdTransformer(self::createStub(ExcludedActionItemIdExcludeItemTransformerInterface::class));

        $actual = $transformer->transform([ExcludedActionItemIdTransformerInterface::KEY_EXCLUDE => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'idAbsent' => [[], 'getId', null];
        yield 'idWrongType' => [[ExcludedActionItemIdTransformerInterface::KEY_ID => 'not-int'], 'getId', null];
        yield 'idValid' => [[ExcludedActionItemIdTransformerInterface::KEY_ID => 7], 'getId', 7];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[ExcludedActionItemIdTransformerInterface::KEY_VALUE => 'not-array'], 'getValue', null];
        yield 'valueValid' => [[ExcludedActionItemIdTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value']], 'getValue', ['test-value-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $excludedActionItemIdExcludeItemModel = self::createStub(ExcludedActionItemIdExcludeItemInterface::class);
        $excludedActionItemIdExcludeItemTransformer = self::createStub(ExcludedActionItemIdExcludeItemTransformerInterface::class);
        $excludedActionItemIdExcludeItemTransformer->method('transform')->willReturn($excludedActionItemIdExcludeItemModel);
        $transformer = new ExcludedActionItemIdTransformer($excludedActionItemIdExcludeItemTransformer);

        $actual = $transformer->transform([ExcludedActionItemIdTransformerInterface::KEY_EXCLUDE => ['test-nested']]);

        self::assertNull($actual->getId());
        self::assertNull($actual->getValue());
    }
}
