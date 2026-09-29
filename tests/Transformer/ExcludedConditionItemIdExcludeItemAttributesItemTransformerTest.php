<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItem;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemAttributesItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ExcludedConditionItemIdExcludeItemAttributesItem::class)]
#[CoversClass(ExcludedConditionItemIdExcludeItemAttributesItemTransformer::class)]
final class ExcludedConditionItemIdExcludeItemAttributesItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::KEY_NAME => 'test-name',
            ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::KEY_EXCLUDED_VALUES => ['test-excluded-values-1', 'test-excluded-values-2'],
        ];

        $transformer = new ExcludedConditionItemIdExcludeItemAttributesItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame(['test-excluded-values-1', 'test-excluded-values-2'], $actual->getExcludedValues());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedConditionItemIdExcludeItemAttributesItemTransformer();

        $actual = $transformer->transform([ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::KEY_NAME => 'test-name'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'excludedValuesAbsent' => [[], 'getExcludedValues', null];
        yield 'excludedValuesWrongType' => [[ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::KEY_EXCLUDED_VALUES => 'not-array'], 'getExcludedValues', null];
        yield 'excludedValuesValid' => [[ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::KEY_EXCLUDED_VALUES => ['test-excluded-values-1', 'test-excluded-values-2']], 'getExcludedValues', ['test-excluded-values-1', 'test-excluded-values-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ExcludedConditionItemIdExcludeItemAttributesItemTransformer();

        $actual = $transformer->transform([ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::KEY_NAME => 'test-name']);

        self::assertNull($actual->getExcludedValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ExcludedConditionItemIdExcludeItemAttributesItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'nameAbsent' => [[], sprintf(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::KEY_NAME)];
        yield 'nameWrongType' => [[ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::KEY_NAME => 42], sprintf(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::KEY_NAME)];
    }
}
