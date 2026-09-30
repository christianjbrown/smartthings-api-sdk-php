<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColors;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardColorsTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardColorsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusStateBoardColors::class)]
#[CoversClass(BasicPlusStateBoardColorsTransformer::class)]
final class BasicPlusStateBoardColorsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $visibleConditionForColorItemModel = self::createStub(VisibleConditionForColorItemInterface::class);
        $visibleConditionForColorItemTransformer = self::createStub(VisibleConditionForColorItemTransformerInterface::class);
        $visibleConditionForColorItemTransformer->method('transform')->willReturn($visibleConditionForColorItemModel);
        $data = [
            BasicPlusStateBoardColorsTransformerInterface::KEY_COLOR => 'test-color',
            BasicPlusStateBoardColorsTransformerInterface::KEY_OPERATOR => 'test-operator',
            BasicPlusStateBoardColorsTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
        ];

        $transformer = new BasicPlusStateBoardColorsTransformer($visibleConditionForColorItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-color', $actual->getColor());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame([$visibleConditionForColorItemModel], $actual->getVisibleConditions());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusStateBoardColorsTransformer(self::createStub(VisibleConditionForColorItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'colorAbsent' => [[], 'getColor', null];
        yield 'colorWrongType' => [[BasicPlusStateBoardColorsTransformerInterface::KEY_COLOR => 42], 'getColor', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusStateBoardColorsTransformer(self::createStub(VisibleConditionForColorItemTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusStateBoardColorsTransformerInterface::KEY_COLOR => 'test-color'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[BasicPlusStateBoardColorsTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[BasicPlusStateBoardColorsTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $visibleConditionForColorItemModel = self::createStub(VisibleConditionForColorItemInterface::class);
        $visibleConditionForColorItemTransformer = self::createStub(VisibleConditionForColorItemTransformerInterface::class);
        $visibleConditionForColorItemTransformer->method('transform')->willReturn($visibleConditionForColorItemModel);
        $transformer = new BasicPlusStateBoardColorsTransformer($visibleConditionForColorItemTransformer);

        $actual = $transformer->transform([BasicPlusStateBoardColorsTransformerInterface::KEY_COLOR => 'test-color']);

        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
    }

    public function testTransformVisibleConditions(): void
    {
        $visibleConditionForColorItemModel = self::createStub(VisibleConditionForColorItemInterface::class);
        $visibleConditionForColorItemTransformer = self::createStub(VisibleConditionForColorItemTransformerInterface::class);
        $visibleConditionForColorItemTransformer->method('transform')->willReturn($visibleConditionForColorItemModel);
        $transformer = new BasicPlusStateBoardColorsTransformer($visibleConditionForColorItemTransformer);
        $base = [BasicPlusStateBoardColorsTransformerInterface::KEY_COLOR => 'test-color'];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [BasicPlusStateBoardColorsTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionForColorItemModel], $transformer->transform($base + [BasicPlusStateBoardColorsTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
