<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeState;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeStateTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ListWithAvailableSizeState::class)]
#[CoversClass(ListWithAvailableSizeStateTransformer::class)]
final class ListWithAvailableSizeStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            ListWithAvailableSizeStateTransformerInterface::KEY_VALUE => 'test-value',
            ListWithAvailableSizeStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            ListWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new ListWithAvailableSizeStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ListWithAvailableSizeStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([ListWithAvailableSizeStateTransformerInterface::KEY_VALUE => 'test-value', ListWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[ListWithAvailableSizeStateTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[ListWithAvailableSizeStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new ListWithAvailableSizeStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([ListWithAvailableSizeStateTransformerInterface::KEY_VALUE => 'test-value', ListWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES => ['test-nested']]);

        self::assertNull($actual->getValueType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ListWithAvailableSizeStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[ListWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES => ['test-nested']], sprintf(ListWithAvailableSizeStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListWithAvailableSizeStateTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[ListWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], ListWithAvailableSizeStateTransformerInterface::KEY_VALUE => 42], sprintf(ListWithAvailableSizeStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListWithAvailableSizeStateTransformerInterface::KEY_VALUE)];
        yield 'alternativesAbsent' => [[ListWithAvailableSizeStateTransformerInterface::KEY_VALUE => 'test-value'], sprintf(ListWithAvailableSizeStateTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES)];
        yield 'alternativesWrongType' => [[ListWithAvailableSizeStateTransformerInterface::KEY_VALUE => 'test-value', ListWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES => 'not-array'], sprintf(ListWithAvailableSizeStateTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES)];
    }
}
