<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListForPanelItemState;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemStateTransformer;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ListForPanelItemState::class)]
#[CoversClass(ListForPanelItemStateTransformer::class)]
final class ListForPanelItemStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            ListForPanelItemStateTransformerInterface::KEY_VALUE => 'test-value',
            ListForPanelItemStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            ListForPanelItemStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new ListForPanelItemStateTransformer($alternativeItemTransformer);

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
        $transformer = new ListForPanelItemStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([ListForPanelItemStateTransformerInterface::KEY_VALUE => 'test-value', ListForPanelItemStateTransformerInterface::KEY_ALTERNATIVES => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[ListForPanelItemStateTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[ListForPanelItemStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new ListForPanelItemStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([ListForPanelItemStateTransformerInterface::KEY_VALUE => 'test-value', ListForPanelItemStateTransformerInterface::KEY_ALTERNATIVES => ['test-nested']]);

        self::assertNull($actual->getValueType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ListForPanelItemStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[ListForPanelItemStateTransformerInterface::KEY_ALTERNATIVES => ['test-nested']], sprintf(ListForPanelItemStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListForPanelItemStateTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[ListForPanelItemStateTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], ListForPanelItemStateTransformerInterface::KEY_VALUE => 42], sprintf(ListForPanelItemStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListForPanelItemStateTransformerInterface::KEY_VALUE)];
        yield 'alternativesAbsent' => [[ListForPanelItemStateTransformerInterface::KEY_VALUE => 'test-value'], sprintf(ListForPanelItemStateTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForPanelItemStateTransformerInterface::KEY_ALTERNATIVES)];
        yield 'alternativesWrongType' => [[ListForPanelItemStateTransformerInterface::KEY_VALUE => 'test-value', ListForPanelItemStateTransformerInterface::KEY_ALTERNATIVES => 'not-array'], sprintf(ListForPanelItemStateTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForPanelItemStateTransformerInterface::KEY_ALTERNATIVES)];
    }
}
