<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItem;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionSupportedOperatorsItemTransformer;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new EnumSliderForAutomationConditionSupportedOperatorsItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'operatorAbsent' => [[EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_LABEL => 'test-label'], sprintf(EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_OPERATOR)];
        yield 'operatorWrongType' => [[EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_LABEL => 'test-label', EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_OPERATOR => 42], sprintf(EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_OPERATOR)];
        yield 'labelAbsent' => [[EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_OPERATOR => 'test-operator'], sprintf(EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_OPERATOR => 'test-operator', EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_LABEL => 42], sprintf(EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::KEY_LABEL)];
    }
}
