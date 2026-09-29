<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItem;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsBarItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemProgressBarsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemProgressBarsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsBarItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsStateItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusItemProgressBarsItem::class)]
#[CoversClass(BasicPlusItemProgressBarsItemTransformer::class)]
final class BasicPlusItemProgressBarsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $basicPlusProgressBarsStateItemModel = self::createStub(BasicPlusProgressBarsStateItemInterface::class);
        $basicPlusProgressBarsStateItemTransformer = self::createStub(BasicPlusProgressBarsStateItemTransformerInterface::class);
        $basicPlusProgressBarsStateItemTransformer->method('transform')->willReturn($basicPlusProgressBarsStateItemModel);
        $basicPlusProgressBarsBarItemModel = self::createStub(BasicPlusProgressBarsBarItemInterface::class);
        $basicPlusProgressBarsBarItemTransformer = self::createStub(BasicPlusProgressBarsBarItemTransformerInterface::class);
        $basicPlusProgressBarsBarItemTransformer->method('transform')->willReturn($basicPlusProgressBarsBarItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            BasicPlusItemProgressBarsItemTransformerInterface::KEY_HEADERS => [['test-nested']],
            BasicPlusItemProgressBarsItemTransformerInterface::KEY_BAR => ['test-nested'],
            BasicPlusItemProgressBarsItemTransformerInterface::KEY_FOOTERS => [['test-nested']],
            BasicPlusItemProgressBarsItemTransformerInterface::KEY_OPERATOR => 'test-operator',
            BasicPlusItemProgressBarsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
        ];

        $transformer = new BasicPlusItemProgressBarsItemTransformer($basicPlusProgressBarsStateItemTransformer, $basicPlusProgressBarsBarItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$basicPlusProgressBarsStateItemModel], $actual->getHeaders());
        self::assertSame($basicPlusProgressBarsBarItemModel, $actual->getBar());
        self::assertSame([$basicPlusProgressBarsStateItemModel], $actual->getFooters());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
    }

    public function testTransformBar(): void
    {
        $basicPlusProgressBarsStateItemModel = self::createStub(BasicPlusProgressBarsStateItemInterface::class);
        $basicPlusProgressBarsStateItemTransformer = self::createStub(BasicPlusProgressBarsStateItemTransformerInterface::class);
        $basicPlusProgressBarsStateItemTransformer->method('transform')->willReturn($basicPlusProgressBarsStateItemModel);
        $basicPlusProgressBarsBarItemModel = self::createStub(BasicPlusProgressBarsBarItemInterface::class);
        $basicPlusProgressBarsBarItemTransformer = self::createStub(BasicPlusProgressBarsBarItemTransformerInterface::class);
        $basicPlusProgressBarsBarItemTransformer->method('transform')->willReturn($basicPlusProgressBarsBarItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusItemProgressBarsItemTransformer($basicPlusProgressBarsStateItemTransformer, $basicPlusProgressBarsBarItemTransformer, $visibleConditionTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getBar());
        self::assertNull($transformer->transform($base + [BasicPlusItemProgressBarsItemTransformerInterface::KEY_BAR => 'test-not-array'])->getBar());
        self::assertSame($basicPlusProgressBarsBarItemModel, $transformer->transform($base + [BasicPlusItemProgressBarsItemTransformerInterface::KEY_BAR => ['test-nested']])->getBar());
    }

    public function testTransformFooters(): void
    {
        $basicPlusProgressBarsStateItemModel = self::createStub(BasicPlusProgressBarsStateItemInterface::class);
        $basicPlusProgressBarsStateItemTransformer = self::createStub(BasicPlusProgressBarsStateItemTransformerInterface::class);
        $basicPlusProgressBarsStateItemTransformer->method('transform')->willReturn($basicPlusProgressBarsStateItemModel);
        $basicPlusProgressBarsBarItemModel = self::createStub(BasicPlusProgressBarsBarItemInterface::class);
        $basicPlusProgressBarsBarItemTransformer = self::createStub(BasicPlusProgressBarsBarItemTransformerInterface::class);
        $basicPlusProgressBarsBarItemTransformer->method('transform')->willReturn($basicPlusProgressBarsBarItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusItemProgressBarsItemTransformer($basicPlusProgressBarsStateItemTransformer, $basicPlusProgressBarsBarItemTransformer, $visibleConditionTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getFooters());
        self::assertNull($transformer->transform($base + [BasicPlusItemProgressBarsItemTransformerInterface::KEY_FOOTERS => 'test-not-array'])->getFooters());
        self::assertSame([$basicPlusProgressBarsStateItemModel], $transformer->transform($base + [BasicPlusItemProgressBarsItemTransformerInterface::KEY_FOOTERS => [['test-nested'], 'test-skipped']])->getFooters());
    }

    public function testTransformHeaders(): void
    {
        $basicPlusProgressBarsStateItemModel = self::createStub(BasicPlusProgressBarsStateItemInterface::class);
        $basicPlusProgressBarsStateItemTransformer = self::createStub(BasicPlusProgressBarsStateItemTransformerInterface::class);
        $basicPlusProgressBarsStateItemTransformer->method('transform')->willReturn($basicPlusProgressBarsStateItemModel);
        $basicPlusProgressBarsBarItemModel = self::createStub(BasicPlusProgressBarsBarItemInterface::class);
        $basicPlusProgressBarsBarItemTransformer = self::createStub(BasicPlusProgressBarsBarItemTransformerInterface::class);
        $basicPlusProgressBarsBarItemTransformer->method('transform')->willReturn($basicPlusProgressBarsBarItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusItemProgressBarsItemTransformer($basicPlusProgressBarsStateItemTransformer, $basicPlusProgressBarsBarItemTransformer, $visibleConditionTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getHeaders());
        self::assertNull($transformer->transform($base + [BasicPlusItemProgressBarsItemTransformerInterface::KEY_HEADERS => 'test-not-array'])->getHeaders());
        self::assertSame([$basicPlusProgressBarsStateItemModel], $transformer->transform($base + [BasicPlusItemProgressBarsItemTransformerInterface::KEY_HEADERS => [['test-nested'], 'test-skipped']])->getHeaders());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusItemProgressBarsItemTransformer(self::createStub(BasicPlusProgressBarsStateItemTransformerInterface::class), self::createStub(BasicPlusProgressBarsBarItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[BasicPlusItemProgressBarsItemTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[BasicPlusItemProgressBarsItemTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $basicPlusProgressBarsStateItemModel = self::createStub(BasicPlusProgressBarsStateItemInterface::class);
        $basicPlusProgressBarsStateItemTransformer = self::createStub(BasicPlusProgressBarsStateItemTransformerInterface::class);
        $basicPlusProgressBarsStateItemTransformer->method('transform')->willReturn($basicPlusProgressBarsStateItemModel);
        $basicPlusProgressBarsBarItemModel = self::createStub(BasicPlusProgressBarsBarItemInterface::class);
        $basicPlusProgressBarsBarItemTransformer = self::createStub(BasicPlusProgressBarsBarItemTransformerInterface::class);
        $basicPlusProgressBarsBarItemTransformer->method('transform')->willReturn($basicPlusProgressBarsBarItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusItemProgressBarsItemTransformer($basicPlusProgressBarsStateItemTransformer, $basicPlusProgressBarsBarItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getHeaders());
        self::assertNull($actual->getBar());
        self::assertNull($actual->getFooters());
        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
    }

    public function testTransformVisibleConditions(): void
    {
        $basicPlusProgressBarsStateItemModel = self::createStub(BasicPlusProgressBarsStateItemInterface::class);
        $basicPlusProgressBarsStateItemTransformer = self::createStub(BasicPlusProgressBarsStateItemTransformerInterface::class);
        $basicPlusProgressBarsStateItemTransformer->method('transform')->willReturn($basicPlusProgressBarsStateItemModel);
        $basicPlusProgressBarsBarItemModel = self::createStub(BasicPlusProgressBarsBarItemInterface::class);
        $basicPlusProgressBarsBarItemTransformer = self::createStub(BasicPlusProgressBarsBarItemTransformerInterface::class);
        $basicPlusProgressBarsBarItemTransformer->method('transform')->willReturn($basicPlusProgressBarsBarItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusItemProgressBarsItemTransformer($basicPlusProgressBarsStateItemTransformer, $basicPlusProgressBarsBarItemTransformer, $visibleConditionTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [BasicPlusItemProgressBarsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [BasicPlusItemProgressBarsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
