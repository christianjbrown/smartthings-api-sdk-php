<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ActionItemInterface;
use ChristianBrown\SmartThings\Model\DashboardForCapability;
use ChristianBrown\SmartThings\Model\PanelItemForCapabilityInterface;
use ChristianBrown\SmartThings\Model\StateItemInterface;
use ChristianBrown\SmartThings\Transformer\ActionItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DashboardForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DashboardForCapabilityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PanelItemForCapabilityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StateItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DashboardForCapability::class)]
#[CoversClass(DashboardForCapabilityTransformer::class)]
final class DashboardForCapabilityTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $stateItemModel = self::createStub(StateItemInterface::class);
        $stateItemTransformer = self::createStub(StateItemTransformerInterface::class);
        $stateItemTransformer->method('transform')->willReturn($stateItemModel);
        $actionItemModel = self::createStub(ActionItemInterface::class);
        $actionItemTransformer = self::createStub(ActionItemTransformerInterface::class);
        $actionItemTransformer->method('transform')->willReturn($actionItemModel);
        $panelItemForCapabilityModel = self::createStub(PanelItemForCapabilityInterface::class);
        $panelItemForCapabilityTransformer = self::createStub(PanelItemForCapabilityTransformerInterface::class);
        $panelItemForCapabilityTransformer->method('transform')->willReturn($panelItemForCapabilityModel);
        $data = [
            DashboardForCapabilityTransformerInterface::KEY_STATES => [['test-nested']],
            DashboardForCapabilityTransformerInterface::KEY_ACTIONS => [['test-nested']],
            DashboardForCapabilityTransformerInterface::KEY_PANEL_ITEMS => [['test-nested']],
        ];

        $transformer = new DashboardForCapabilityTransformer($stateItemTransformer, $actionItemTransformer, $panelItemForCapabilityTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$stateItemModel], $actual->getStates());
        self::assertSame([$actionItemModel], $actual->getActions());
        self::assertSame([$panelItemForCapabilityModel], $actual->getPanelItems());
    }

    public function testTransformActions(): void
    {
        $stateItemModel = self::createStub(StateItemInterface::class);
        $stateItemTransformer = self::createStub(StateItemTransformerInterface::class);
        $stateItemTransformer->method('transform')->willReturn($stateItemModel);
        $actionItemModel = self::createStub(ActionItemInterface::class);
        $actionItemTransformer = self::createStub(ActionItemTransformerInterface::class);
        $actionItemTransformer->method('transform')->willReturn($actionItemModel);
        $panelItemForCapabilityModel = self::createStub(PanelItemForCapabilityInterface::class);
        $panelItemForCapabilityTransformer = self::createStub(PanelItemForCapabilityTransformerInterface::class);
        $panelItemForCapabilityTransformer->method('transform')->willReturn($panelItemForCapabilityModel);
        $transformer = new DashboardForCapabilityTransformer($stateItemTransformer, $actionItemTransformer, $panelItemForCapabilityTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getActions());
        self::assertNull($transformer->transform($base + [DashboardForCapabilityTransformerInterface::KEY_ACTIONS => 'test-not-array'])->getActions());
        self::assertSame([$actionItemModel], $transformer->transform($base + [DashboardForCapabilityTransformerInterface::KEY_ACTIONS => [['test-nested'], 'test-skipped']])->getActions());
    }

    public function testTransformPanelItems(): void
    {
        $stateItemModel = self::createStub(StateItemInterface::class);
        $stateItemTransformer = self::createStub(StateItemTransformerInterface::class);
        $stateItemTransformer->method('transform')->willReturn($stateItemModel);
        $actionItemModel = self::createStub(ActionItemInterface::class);
        $actionItemTransformer = self::createStub(ActionItemTransformerInterface::class);
        $actionItemTransformer->method('transform')->willReturn($actionItemModel);
        $panelItemForCapabilityModel = self::createStub(PanelItemForCapabilityInterface::class);
        $panelItemForCapabilityTransformer = self::createStub(PanelItemForCapabilityTransformerInterface::class);
        $panelItemForCapabilityTransformer->method('transform')->willReturn($panelItemForCapabilityModel);
        $transformer = new DashboardForCapabilityTransformer($stateItemTransformer, $actionItemTransformer, $panelItemForCapabilityTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getPanelItems());
        self::assertNull($transformer->transform($base + [DashboardForCapabilityTransformerInterface::KEY_PANEL_ITEMS => 'test-not-array'])->getPanelItems());
        self::assertSame([$panelItemForCapabilityModel], $transformer->transform($base + [DashboardForCapabilityTransformerInterface::KEY_PANEL_ITEMS => [['test-nested'], 'test-skipped']])->getPanelItems());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $stateItemModel = self::createStub(StateItemInterface::class);
        $stateItemTransformer = self::createStub(StateItemTransformerInterface::class);
        $stateItemTransformer->method('transform')->willReturn($stateItemModel);
        $actionItemModel = self::createStub(ActionItemInterface::class);
        $actionItemTransformer = self::createStub(ActionItemTransformerInterface::class);
        $actionItemTransformer->method('transform')->willReturn($actionItemModel);
        $panelItemForCapabilityModel = self::createStub(PanelItemForCapabilityInterface::class);
        $panelItemForCapabilityTransformer = self::createStub(PanelItemForCapabilityTransformerInterface::class);
        $panelItemForCapabilityTransformer->method('transform')->willReturn($panelItemForCapabilityModel);
        $transformer = new DashboardForCapabilityTransformer($stateItemTransformer, $actionItemTransformer, $panelItemForCapabilityTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getStates());
        self::assertNull($actual->getActions());
        self::assertNull($actual->getPanelItems());
    }

    public function testTransformStates(): void
    {
        $stateItemModel = self::createStub(StateItemInterface::class);
        $stateItemTransformer = self::createStub(StateItemTransformerInterface::class);
        $stateItemTransformer->method('transform')->willReturn($stateItemModel);
        $actionItemModel = self::createStub(ActionItemInterface::class);
        $actionItemTransformer = self::createStub(ActionItemTransformerInterface::class);
        $actionItemTransformer->method('transform')->willReturn($actionItemModel);
        $panelItemForCapabilityModel = self::createStub(PanelItemForCapabilityInterface::class);
        $panelItemForCapabilityTransformer = self::createStub(PanelItemForCapabilityTransformerInterface::class);
        $panelItemForCapabilityTransformer->method('transform')->willReturn($panelItemForCapabilityModel);
        $transformer = new DashboardForCapabilityTransformer($stateItemTransformer, $actionItemTransformer, $panelItemForCapabilityTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getStates());
        self::assertNull($transformer->transform($base + [DashboardForCapabilityTransformerInterface::KEY_STATES => 'test-not-array'])->getStates());
        self::assertSame([$stateItemModel], $transformer->transform($base + [DashboardForCapabilityTransformerInterface::KEY_STATES => [['test-nested'], 'test-skipped']])->getStates());
    }
}
