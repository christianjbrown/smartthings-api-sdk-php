<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ActionsArrayItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItemForPresentationInterface;
use ChristianBrown\SmartThings\Model\Dashboard;
use ChristianBrown\SmartThings\Model\GroupVisibleConditionsInterface;
use ChristianBrown\SmartThings\Model\StatesArrayItemInterface;
use ChristianBrown\SmartThings\Transformer\ActionsArrayItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemForPresentationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DashboardTransformer;
use ChristianBrown\SmartThings\Transformer\DashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\GroupVisibleConditionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StatesArrayItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Dashboard::class)]
#[CoversClass(DashboardTransformer::class)]
final class DashboardTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $statesArrayItemModel = self::createStub(StatesArrayItemInterface::class);
        $statesArrayItemTransformer = self::createStub(StatesArrayItemTransformerInterface::class);
        $statesArrayItemTransformer->method('transform')->willReturn($statesArrayItemModel);
        $actionsArrayItemModel = self::createStub(ActionsArrayItemInterface::class);
        $actionsArrayItemTransformer = self::createStub(ActionsArrayItemTransformerInterface::class);
        $actionsArrayItemTransformer->method('transform')->willReturn($actionsArrayItemModel);
        $basicPlusItemForPresentationModel = self::createStub(BasicPlusItemForPresentationInterface::class);
        $basicPlusItemForPresentationTransformer = self::createStub(BasicPlusItemForPresentationTransformerInterface::class);
        $basicPlusItemForPresentationTransformer->method('transform')->willReturn($basicPlusItemForPresentationModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $data = [
            DashboardTransformerInterface::KEY_STATES => [['test-nested']],
            DashboardTransformerInterface::KEY_ACTIONS => [['test-nested']],
            DashboardTransformerInterface::KEY_BASIC_PLUS => [['test-nested']],
            DashboardTransformerInterface::KEY_GROUP_VISIBLE_CONDITIONS => ['test-nested'],
        ];

        $transformer = new DashboardTransformer($statesArrayItemTransformer, $actionsArrayItemTransformer, $basicPlusItemForPresentationTransformer, $groupVisibleConditionsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$statesArrayItemModel], $actual->getStates());
        self::assertSame([$actionsArrayItemModel], $actual->getActions());
        self::assertSame([$basicPlusItemForPresentationModel], $actual->getBasicPlus());
        self::assertSame($groupVisibleConditionsModel, $actual->getGroupVisibleConditions());
    }

    public function testTransformActions(): void
    {
        $statesArrayItemModel = self::createStub(StatesArrayItemInterface::class);
        $statesArrayItemTransformer = self::createStub(StatesArrayItemTransformerInterface::class);
        $statesArrayItemTransformer->method('transform')->willReturn($statesArrayItemModel);
        $actionsArrayItemModel = self::createStub(ActionsArrayItemInterface::class);
        $actionsArrayItemTransformer = self::createStub(ActionsArrayItemTransformerInterface::class);
        $actionsArrayItemTransformer->method('transform')->willReturn($actionsArrayItemModel);
        $basicPlusItemForPresentationModel = self::createStub(BasicPlusItemForPresentationInterface::class);
        $basicPlusItemForPresentationTransformer = self::createStub(BasicPlusItemForPresentationTransformerInterface::class);
        $basicPlusItemForPresentationTransformer->method('transform')->willReturn($basicPlusItemForPresentationModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DashboardTransformer($statesArrayItemTransformer, $actionsArrayItemTransformer, $basicPlusItemForPresentationTransformer, $groupVisibleConditionsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getActions());
        self::assertNull($transformer->transform($base + [DashboardTransformerInterface::KEY_ACTIONS => 'test-not-array'])->getActions());
        self::assertSame([$actionsArrayItemModel], $transformer->transform($base + [DashboardTransformerInterface::KEY_ACTIONS => [['test-nested'], 'test-skipped']])->getActions());
    }

    public function testTransformBasicPlus(): void
    {
        $statesArrayItemModel = self::createStub(StatesArrayItemInterface::class);
        $statesArrayItemTransformer = self::createStub(StatesArrayItemTransformerInterface::class);
        $statesArrayItemTransformer->method('transform')->willReturn($statesArrayItemModel);
        $actionsArrayItemModel = self::createStub(ActionsArrayItemInterface::class);
        $actionsArrayItemTransformer = self::createStub(ActionsArrayItemTransformerInterface::class);
        $actionsArrayItemTransformer->method('transform')->willReturn($actionsArrayItemModel);
        $basicPlusItemForPresentationModel = self::createStub(BasicPlusItemForPresentationInterface::class);
        $basicPlusItemForPresentationTransformer = self::createStub(BasicPlusItemForPresentationTransformerInterface::class);
        $basicPlusItemForPresentationTransformer->method('transform')->willReturn($basicPlusItemForPresentationModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DashboardTransformer($statesArrayItemTransformer, $actionsArrayItemTransformer, $basicPlusItemForPresentationTransformer, $groupVisibleConditionsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getBasicPlus());
        self::assertNull($transformer->transform($base + [DashboardTransformerInterface::KEY_BASIC_PLUS => 'test-not-array'])->getBasicPlus());
        self::assertSame([$basicPlusItemForPresentationModel], $transformer->transform($base + [DashboardTransformerInterface::KEY_BASIC_PLUS => [['test-nested'], 'test-skipped']])->getBasicPlus());
    }

    public function testTransformGroupVisibleConditions(): void
    {
        $statesArrayItemModel = self::createStub(StatesArrayItemInterface::class);
        $statesArrayItemTransformer = self::createStub(StatesArrayItemTransformerInterface::class);
        $statesArrayItemTransformer->method('transform')->willReturn($statesArrayItemModel);
        $actionsArrayItemModel = self::createStub(ActionsArrayItemInterface::class);
        $actionsArrayItemTransformer = self::createStub(ActionsArrayItemTransformerInterface::class);
        $actionsArrayItemTransformer->method('transform')->willReturn($actionsArrayItemModel);
        $basicPlusItemForPresentationModel = self::createStub(BasicPlusItemForPresentationInterface::class);
        $basicPlusItemForPresentationTransformer = self::createStub(BasicPlusItemForPresentationTransformerInterface::class);
        $basicPlusItemForPresentationTransformer->method('transform')->willReturn($basicPlusItemForPresentationModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DashboardTransformer($statesArrayItemTransformer, $actionsArrayItemTransformer, $basicPlusItemForPresentationTransformer, $groupVisibleConditionsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getGroupVisibleConditions());
        self::assertNull($transformer->transform($base + [DashboardTransformerInterface::KEY_GROUP_VISIBLE_CONDITIONS => 'test-not-array'])->getGroupVisibleConditions());
        self::assertSame($groupVisibleConditionsModel, $transformer->transform($base + [DashboardTransformerInterface::KEY_GROUP_VISIBLE_CONDITIONS => ['test-nested']])->getGroupVisibleConditions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $statesArrayItemModel = self::createStub(StatesArrayItemInterface::class);
        $statesArrayItemTransformer = self::createStub(StatesArrayItemTransformerInterface::class);
        $statesArrayItemTransformer->method('transform')->willReturn($statesArrayItemModel);
        $actionsArrayItemModel = self::createStub(ActionsArrayItemInterface::class);
        $actionsArrayItemTransformer = self::createStub(ActionsArrayItemTransformerInterface::class);
        $actionsArrayItemTransformer->method('transform')->willReturn($actionsArrayItemModel);
        $basicPlusItemForPresentationModel = self::createStub(BasicPlusItemForPresentationInterface::class);
        $basicPlusItemForPresentationTransformer = self::createStub(BasicPlusItemForPresentationTransformerInterface::class);
        $basicPlusItemForPresentationTransformer->method('transform')->willReturn($basicPlusItemForPresentationModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DashboardTransformer($statesArrayItemTransformer, $actionsArrayItemTransformer, $basicPlusItemForPresentationTransformer, $groupVisibleConditionsTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getStates());
        self::assertNull($actual->getActions());
        self::assertNull($actual->getBasicPlus());
        self::assertNull($actual->getGroupVisibleConditions());
    }

    public function testTransformStates(): void
    {
        $statesArrayItemModel = self::createStub(StatesArrayItemInterface::class);
        $statesArrayItemTransformer = self::createStub(StatesArrayItemTransformerInterface::class);
        $statesArrayItemTransformer->method('transform')->willReturn($statesArrayItemModel);
        $actionsArrayItemModel = self::createStub(ActionsArrayItemInterface::class);
        $actionsArrayItemTransformer = self::createStub(ActionsArrayItemTransformerInterface::class);
        $actionsArrayItemTransformer->method('transform')->willReturn($actionsArrayItemModel);
        $basicPlusItemForPresentationModel = self::createStub(BasicPlusItemForPresentationInterface::class);
        $basicPlusItemForPresentationTransformer = self::createStub(BasicPlusItemForPresentationTransformerInterface::class);
        $basicPlusItemForPresentationTransformer->method('transform')->willReturn($basicPlusItemForPresentationModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DashboardTransformer($statesArrayItemTransformer, $actionsArrayItemTransformer, $basicPlusItemForPresentationTransformer, $groupVisibleConditionsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getStates());
        self::assertNull($transformer->transform($base + [DashboardTransformerInterface::KEY_STATES => 'test-not-array'])->getStates());
        self::assertSame([$statesArrayItemModel], $transformer->transform($base + [DashboardTransformerInterface::KEY_STATES => [['test-nested'], 'test-skipped']])->getStates());
    }
}
