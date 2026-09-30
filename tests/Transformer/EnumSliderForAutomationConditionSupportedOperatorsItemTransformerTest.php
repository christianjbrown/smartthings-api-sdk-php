<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItem;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionSupportedOperatorsItemTransformer;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EnumSliderForAutomationConditionSupportedOperatorsItem::class)]
#[CoversClass(EnumSliderForAutomationConditionSupportedOperatorsItemTransformer::class)]
final class EnumSliderForAutomationConditionSupportedOperatorsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_OPERATOR => 'test-operator',
            EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_LABEL => 'test-label',
        ];

        $transformer = new EnumSliderForAutomationConditionSupportedOperatorsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame('test-label', $actual->getLabel());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new EnumSliderForAutomationConditionSupportedOperatorsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'operatorAbsent' => [[EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_LABEL => 'test-label'], 'getOperator', null];
        yield 'operatorWrongType' => [[EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_LABEL => 'test-label', EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'labelAbsent' => [[EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getLabel', null];
        yield 'labelWrongType' => [[EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_OPERATOR => 'test-operator', EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
    }
}
