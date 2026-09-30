<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PanelForDeviceConfig;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigItemsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PanelForDeviceConfig::class)]
#[CoversClass(PanelForDeviceConfigTransformer::class)]
final class PanelForDeviceConfigTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $panelForDeviceConfigItemsItemModel = self::createStub(PanelForDeviceConfigItemsItemInterface::class);
        $panelForDeviceConfigItemsItemTransformer = self::createStub(PanelForDeviceConfigItemsItemTransformerInterface::class);
        $panelForDeviceConfigItemsItemTransformer->method('transform')->willReturn($panelForDeviceConfigItemsItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            PanelForDeviceConfigTransformerInterface::KEY_ITEMS => [['test-nested']],
            PanelForDeviceConfigTransformerInterface::KEY_OPERATOR => 'test-operator',
            PanelForDeviceConfigTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
            PanelForDeviceConfigTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true,
        ];

        $transformer = new PanelForDeviceConfigTransformer($panelForDeviceConfigItemsItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$panelForDeviceConfigItemsItemModel], $actual->getItems());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
        self::assertTrue($actual->getHideDashboardActions());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PanelForDeviceConfigTransformer(self::createStub(PanelForDeviceConfigItemsItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'itemsAbsent' => [[], 'getItems', []];
        yield 'itemsWrongType' => [[PanelForDeviceConfigTransformerInterface::KEY_ITEMS => 'not-array'], 'getItems', []];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PanelForDeviceConfigTransformer(self::createStub(PanelForDeviceConfigItemsItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([PanelForDeviceConfigTransformerInterface::KEY_ITEMS => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[PanelForDeviceConfigTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[PanelForDeviceConfigTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
        yield 'hideDashboardActionsAbsent' => [[], 'getHideDashboardActions', null];
        yield 'hideDashboardActionsWrongType' => [[PanelForDeviceConfigTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => 'not-bool'], 'getHideDashboardActions', null];
        yield 'hideDashboardActionsValid' => [[PanelForDeviceConfigTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true], 'getHideDashboardActions', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $panelForDeviceConfigItemsItemModel = self::createStub(PanelForDeviceConfigItemsItemInterface::class);
        $panelForDeviceConfigItemsItemTransformer = self::createStub(PanelForDeviceConfigItemsItemTransformerInterface::class);
        $panelForDeviceConfigItemsItemTransformer->method('transform')->willReturn($panelForDeviceConfigItemsItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDeviceConfigTransformer($panelForDeviceConfigItemsItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([PanelForDeviceConfigTransformerInterface::KEY_ITEMS => ['test-nested']]);

        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
        self::assertNull($actual->getHideDashboardActions());
    }

    public function testTransformVisibleConditions(): void
    {
        $panelForDeviceConfigItemsItemModel = self::createStub(PanelForDeviceConfigItemsItemInterface::class);
        $panelForDeviceConfigItemsItemTransformer = self::createStub(PanelForDeviceConfigItemsItemTransformerInterface::class);
        $panelForDeviceConfigItemsItemTransformer->method('transform')->willReturn($panelForDeviceConfigItemsItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDeviceConfigTransformer($panelForDeviceConfigItemsItemTransformer, $visibleConditionTransformer);
        $base = [PanelForDeviceConfigTransformerInterface::KEY_ITEMS => ['test-nested']];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [PanelForDeviceConfigTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [PanelForDeviceConfigTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
