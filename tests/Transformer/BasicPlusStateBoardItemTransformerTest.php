<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColorsInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardColorsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(BasicPlusStateBoardItem::class)]
#[CoversClass(BasicPlusStateBoardItemTransformer::class)]
final class BasicPlusStateBoardItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $basicPlusStateBoardColorsModel = self::createStub(BasicPlusStateBoardColorsInterface::class);
        $basicPlusStateBoardColorsTransformer = self::createStub(BasicPlusStateBoardColorsTransformerInterface::class);
        $basicPlusStateBoardColorsTransformer->method('transform')->willReturn($basicPlusStateBoardColorsModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            BasicPlusStateBoardItemTransformerInterface::KEY_VERSION => 7,
            BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component',
            BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value',
            BasicPlusStateBoardItemTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label',
            BasicPlusStateBoardItemTransformerInterface::KEY_UNIT => 'test-unit',
            BasicPlusStateBoardItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            BasicPlusStateBoardItemTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            BasicPlusStateBoardItemTransformerInterface::KEY_COLORS => [['test-nested']],
            BasicPlusStateBoardItemTransformerInterface::KEY_OPERATOR => 'test-operator',
            BasicPlusStateBoardItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
        ];

        $transformer = new BasicPlusStateBoardItemTransformer($alternativeItemTransformer, $basicPlusStateBoardColorsTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame([$basicPlusStateBoardColorsModel], $actual->getColors());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $basicPlusStateBoardColorsModel = self::createStub(BasicPlusStateBoardColorsInterface::class);
        $basicPlusStateBoardColorsTransformer = self::createStub(BasicPlusStateBoardColorsTransformerInterface::class);
        $basicPlusStateBoardColorsTransformer->method('transform')->willReturn($basicPlusStateBoardColorsModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusStateBoardItemTransformer($alternativeItemTransformer, $basicPlusStateBoardColorsTransformer, $visibleConditionTransformer);
        $base = [BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [BasicPlusStateBoardItemTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [BasicPlusStateBoardItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    public function testTransformColors(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $basicPlusStateBoardColorsModel = self::createStub(BasicPlusStateBoardColorsInterface::class);
        $basicPlusStateBoardColorsTransformer = self::createStub(BasicPlusStateBoardColorsTransformerInterface::class);
        $basicPlusStateBoardColorsTransformer->method('transform')->willReturn($basicPlusStateBoardColorsModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusStateBoardItemTransformer($alternativeItemTransformer, $basicPlusStateBoardColorsTransformer, $visibleConditionTransformer);
        $base = [BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label'];

        self::assertNull($transformer->transform($base)->getColors());
        self::assertNull($transformer->transform($base + [BasicPlusStateBoardItemTransformerInterface::KEY_COLORS => 'test-not-array'])->getColors());
        self::assertSame([$basicPlusStateBoardColorsModel], $transformer->transform($base + [BasicPlusStateBoardItemTransformerInterface::KEY_COLORS => [['test-nested'], 'test-skipped']])->getColors());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusStateBoardItemTransformer(self::createStub(AlternativeItemTransformerInterface::class), self::createStub(BasicPlusStateBoardColorsTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[BasicPlusStateBoardItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[BasicPlusStateBoardItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[BasicPlusStateBoardItemTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[BasicPlusStateBoardItemTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[BasicPlusStateBoardItemTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[BasicPlusStateBoardItemTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[BasicPlusStateBoardItemTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[BasicPlusStateBoardItemTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[BasicPlusStateBoardItemTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[BasicPlusStateBoardItemTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $basicPlusStateBoardColorsModel = self::createStub(BasicPlusStateBoardColorsInterface::class);
        $basicPlusStateBoardColorsTransformer = self::createStub(BasicPlusStateBoardColorsTransformerInterface::class);
        $basicPlusStateBoardColorsTransformer->method('transform')->willReturn($basicPlusStateBoardColorsModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusStateBoardItemTransformer($alternativeItemTransformer, $basicPlusStateBoardColorsTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getValueType());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getIconUrl());
        self::assertNull($actual->getColors());
        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new BasicPlusStateBoardItemTransformer(self::createStub(AlternativeItemTransformerInterface::class), self::createStub(BasicPlusStateBoardColorsTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilityAbsent' => [[BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label'], sprintf(BasicPlusStateBoardItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 42], sprintf(BasicPlusStateBoardItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY)];
        yield 'componentAbsent' => [[BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label'], sprintf(BasicPlusStateBoardItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 42], sprintf(BasicPlusStateBoardItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT)];
        yield 'valueAbsent' => [[BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label'], sprintf(BasicPlusStateBoardItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusStateBoardItemTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 42], sprintf(BasicPlusStateBoardItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusStateBoardItemTransformerInterface::KEY_VALUE)];
        yield 'labelAbsent' => [[BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value'], sprintf(BasicPlusStateBoardItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusStateBoardItemTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 42], sprintf(BasicPlusStateBoardItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusStateBoardItemTransformerInterface::KEY_LABEL)];
    }

    public function testTransformVisibleConditions(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $basicPlusStateBoardColorsModel = self::createStub(BasicPlusStateBoardColorsInterface::class);
        $basicPlusStateBoardColorsTransformer = self::createStub(BasicPlusStateBoardColorsTransformerInterface::class);
        $basicPlusStateBoardColorsTransformer->method('transform')->willReturn($basicPlusStateBoardColorsModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusStateBoardItemTransformer($alternativeItemTransformer, $basicPlusStateBoardColorsTransformer, $visibleConditionTransformer);
        $base = [BasicPlusStateBoardItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusStateBoardItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusStateBoardItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusStateBoardItemTransformerInterface::KEY_LABEL => 'test-label'];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [BasicPlusStateBoardItemTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [BasicPlusStateBoardItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
