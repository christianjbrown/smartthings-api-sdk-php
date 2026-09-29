<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ExcludedConditionItem;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ExcludedConditionItem::class)]
#[CoversClass(ExcludedConditionItemTransformer::class)]
final class ExcludedConditionItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $excludedConditionItemIdExcludeItemModel = self::createStub(ExcludedConditionItemIdExcludeItemInterface::class);
        $excludedConditionItemIdExcludeItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemModel);
        $data = [
            ExcludedConditionItemTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
            ExcludedConditionItemTransformerInterface::KEY_EXCLUDE => [['test-nested']],
        ];

        $transformer = new ExcludedConditionItemTransformer($excludedConditionItemIdExcludeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-value-key' => 'test-value'], $actual->getValue());
        self::assertSame([$excludedConditionItemIdExcludeItemModel], $actual->getExclude());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedConditionItemTransformer(self::createStub(ExcludedConditionItemIdExcludeItemTransformerInterface::class));

        $actual = $transformer->transform([ExcludedConditionItemTransformerInterface::KEY_EXCLUDE => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[ExcludedConditionItemTransformerInterface::KEY_VALUE => 'not-array'], 'getValue', null];
        yield 'valueValid' => [[ExcludedConditionItemTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value']], 'getValue', ['test-value-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $excludedConditionItemIdExcludeItemModel = self::createStub(ExcludedConditionItemIdExcludeItemInterface::class);
        $excludedConditionItemIdExcludeItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemModel);
        $transformer = new ExcludedConditionItemTransformer($excludedConditionItemIdExcludeItemTransformer);

        $actual = $transformer->transform([ExcludedConditionItemTransformerInterface::KEY_EXCLUDE => ['test-nested']]);

        self::assertNull($actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ExcludedConditionItemTransformer(self::createStub(ExcludedConditionItemIdExcludeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'excludeAbsent' => [[], sprintf(ExcludedConditionItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ExcludedConditionItemTransformerInterface::KEY_EXCLUDE)];
        yield 'excludeWrongType' => [[ExcludedConditionItemTransformerInterface::KEY_EXCLUDE => 'not-array'], sprintf(ExcludedConditionItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ExcludedConditionItemTransformerInterface::KEY_EXCLUDE)];
    }
}
