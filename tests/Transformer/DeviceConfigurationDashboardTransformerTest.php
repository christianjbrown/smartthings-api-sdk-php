<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboard;
use ChristianBrown\SmartThings\Model\GroupVisibleConditionsInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\GroupVisibleConditionsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationDashboard::class)]
#[CoversClass(DeviceConfigurationDashboardTransformer::class)]
final class DeviceConfigurationDashboardTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceConfigEntryForDashboardStateModel = self::createStub(DeviceConfigEntryForDashboardStateInterface::class);
        $deviceConfigEntryForDashboardStateTransformer = self::createStub(DeviceConfigEntryForDashboardStateTransformerInterface::class);
        $deviceConfigEntryForDashboardStateTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateModel);
        $deviceConfigEntryForDashboardActionModel = self::createStub(DeviceConfigEntryForDashboardActionInterface::class);
        $deviceConfigEntryForDashboardActionTransformer = self::createStub(DeviceConfigEntryForDashboardActionTransformerInterface::class);
        $deviceConfigEntryForDashboardActionTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionModel);
        $basicPlusItemModel = self::createStub(BasicPlusItemInterface::class);
        $basicPlusItemTransformer = self::createStub(BasicPlusItemTransformerInterface::class);
        $basicPlusItemTransformer->method('transform')->willReturn($basicPlusItemModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $data = [
            DeviceConfigurationDashboardTransformerInterface::KEY_STATES => [['test-nested']],
            DeviceConfigurationDashboardTransformerInterface::KEY_ACTIONS => [['test-nested']],
            DeviceConfigurationDashboardTransformerInterface::KEY_BASIC_PLUS => [['test-nested']],
            DeviceConfigurationDashboardTransformerInterface::KEY_GROUP_VISIBLE_CONDITIONS => ['test-nested'],
        ];

        $transformer = new DeviceConfigurationDashboardTransformer($deviceConfigEntryForDashboardStateTransformer, $deviceConfigEntryForDashboardActionTransformer, $basicPlusItemTransformer, $groupVisibleConditionsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$deviceConfigEntryForDashboardStateModel], $actual->getStates());
        self::assertSame([$deviceConfigEntryForDashboardActionModel], $actual->getActions());
        self::assertSame([$basicPlusItemModel], $actual->getBasicPlus());
        self::assertSame($groupVisibleConditionsModel, $actual->getGroupVisibleConditions());
    }

    public function testTransformActions(): void
    {
        $deviceConfigEntryForDashboardStateModel = self::createStub(DeviceConfigEntryForDashboardStateInterface::class);
        $deviceConfigEntryForDashboardStateTransformer = self::createStub(DeviceConfigEntryForDashboardStateTransformerInterface::class);
        $deviceConfigEntryForDashboardStateTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateModel);
        $deviceConfigEntryForDashboardActionModel = self::createStub(DeviceConfigEntryForDashboardActionInterface::class);
        $deviceConfigEntryForDashboardActionTransformer = self::createStub(DeviceConfigEntryForDashboardActionTransformerInterface::class);
        $deviceConfigEntryForDashboardActionTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionModel);
        $basicPlusItemModel = self::createStub(BasicPlusItemInterface::class);
        $basicPlusItemTransformer = self::createStub(BasicPlusItemTransformerInterface::class);
        $basicPlusItemTransformer->method('transform')->willReturn($basicPlusItemModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DeviceConfigurationDashboardTransformer($deviceConfigEntryForDashboardStateTransformer, $deviceConfigEntryForDashboardActionTransformer, $basicPlusItemTransformer, $groupVisibleConditionsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getActions());
        self::assertNull($transformer->transform($base + [DeviceConfigurationDashboardTransformerInterface::KEY_ACTIONS => 'test-not-array'])->getActions());
        self::assertSame([$deviceConfigEntryForDashboardActionModel], $transformer->transform($base + [DeviceConfigurationDashboardTransformerInterface::KEY_ACTIONS => [['test-nested'], 'test-skipped']])->getActions());
    }

    public function testTransformBasicPlus(): void
    {
        $deviceConfigEntryForDashboardStateModel = self::createStub(DeviceConfigEntryForDashboardStateInterface::class);
        $deviceConfigEntryForDashboardStateTransformer = self::createStub(DeviceConfigEntryForDashboardStateTransformerInterface::class);
        $deviceConfigEntryForDashboardStateTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateModel);
        $deviceConfigEntryForDashboardActionModel = self::createStub(DeviceConfigEntryForDashboardActionInterface::class);
        $deviceConfigEntryForDashboardActionTransformer = self::createStub(DeviceConfigEntryForDashboardActionTransformerInterface::class);
        $deviceConfigEntryForDashboardActionTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionModel);
        $basicPlusItemModel = self::createStub(BasicPlusItemInterface::class);
        $basicPlusItemTransformer = self::createStub(BasicPlusItemTransformerInterface::class);
        $basicPlusItemTransformer->method('transform')->willReturn($basicPlusItemModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DeviceConfigurationDashboardTransformer($deviceConfigEntryForDashboardStateTransformer, $deviceConfigEntryForDashboardActionTransformer, $basicPlusItemTransformer, $groupVisibleConditionsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getBasicPlus());
        self::assertNull($transformer->transform($base + [DeviceConfigurationDashboardTransformerInterface::KEY_BASIC_PLUS => 'test-not-array'])->getBasicPlus());
        self::assertSame([$basicPlusItemModel], $transformer->transform($base + [DeviceConfigurationDashboardTransformerInterface::KEY_BASIC_PLUS => [['test-nested'], 'test-skipped']])->getBasicPlus());
    }

    public function testTransformGroupVisibleConditions(): void
    {
        $deviceConfigEntryForDashboardStateModel = self::createStub(DeviceConfigEntryForDashboardStateInterface::class);
        $deviceConfigEntryForDashboardStateTransformer = self::createStub(DeviceConfigEntryForDashboardStateTransformerInterface::class);
        $deviceConfigEntryForDashboardStateTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateModel);
        $deviceConfigEntryForDashboardActionModel = self::createStub(DeviceConfigEntryForDashboardActionInterface::class);
        $deviceConfigEntryForDashboardActionTransformer = self::createStub(DeviceConfigEntryForDashboardActionTransformerInterface::class);
        $deviceConfigEntryForDashboardActionTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionModel);
        $basicPlusItemModel = self::createStub(BasicPlusItemInterface::class);
        $basicPlusItemTransformer = self::createStub(BasicPlusItemTransformerInterface::class);
        $basicPlusItemTransformer->method('transform')->willReturn($basicPlusItemModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DeviceConfigurationDashboardTransformer($deviceConfigEntryForDashboardStateTransformer, $deviceConfigEntryForDashboardActionTransformer, $basicPlusItemTransformer, $groupVisibleConditionsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getGroupVisibleConditions());
        self::assertNull($transformer->transform($base + [DeviceConfigurationDashboardTransformerInterface::KEY_GROUP_VISIBLE_CONDITIONS => 'test-not-array'])->getGroupVisibleConditions());
        self::assertSame($groupVisibleConditionsModel, $transformer->transform($base + [DeviceConfigurationDashboardTransformerInterface::KEY_GROUP_VISIBLE_CONDITIONS => ['test-nested']])->getGroupVisibleConditions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceConfigEntryForDashboardStateModel = self::createStub(DeviceConfigEntryForDashboardStateInterface::class);
        $deviceConfigEntryForDashboardStateTransformer = self::createStub(DeviceConfigEntryForDashboardStateTransformerInterface::class);
        $deviceConfigEntryForDashboardStateTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateModel);
        $deviceConfigEntryForDashboardActionModel = self::createStub(DeviceConfigEntryForDashboardActionInterface::class);
        $deviceConfigEntryForDashboardActionTransformer = self::createStub(DeviceConfigEntryForDashboardActionTransformerInterface::class);
        $deviceConfigEntryForDashboardActionTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionModel);
        $basicPlusItemModel = self::createStub(BasicPlusItemInterface::class);
        $basicPlusItemTransformer = self::createStub(BasicPlusItemTransformerInterface::class);
        $basicPlusItemTransformer->method('transform')->willReturn($basicPlusItemModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DeviceConfigurationDashboardTransformer($deviceConfigEntryForDashboardStateTransformer, $deviceConfigEntryForDashboardActionTransformer, $basicPlusItemTransformer, $groupVisibleConditionsTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getStates());
        self::assertNull($actual->getActions());
        self::assertNull($actual->getBasicPlus());
        self::assertNull($actual->getGroupVisibleConditions());
    }

    public function testTransformStates(): void
    {
        $deviceConfigEntryForDashboardStateModel = self::createStub(DeviceConfigEntryForDashboardStateInterface::class);
        $deviceConfigEntryForDashboardStateTransformer = self::createStub(DeviceConfigEntryForDashboardStateTransformerInterface::class);
        $deviceConfigEntryForDashboardStateTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateModel);
        $deviceConfigEntryForDashboardActionModel = self::createStub(DeviceConfigEntryForDashboardActionInterface::class);
        $deviceConfigEntryForDashboardActionTransformer = self::createStub(DeviceConfigEntryForDashboardActionTransformerInterface::class);
        $deviceConfigEntryForDashboardActionTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionModel);
        $basicPlusItemModel = self::createStub(BasicPlusItemInterface::class);
        $basicPlusItemTransformer = self::createStub(BasicPlusItemTransformerInterface::class);
        $basicPlusItemTransformer->method('transform')->willReturn($basicPlusItemModel);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsTransformer = self::createStub(GroupVisibleConditionsTransformerInterface::class);
        $groupVisibleConditionsTransformer->method('transform')->willReturn($groupVisibleConditionsModel);
        $transformer = new DeviceConfigurationDashboardTransformer($deviceConfigEntryForDashboardStateTransformer, $deviceConfigEntryForDashboardActionTransformer, $basicPlusItemTransformer, $groupVisibleConditionsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getStates());
        self::assertNull($transformer->transform($base + [DeviceConfigurationDashboardTransformerInterface::KEY_STATES => 'test-not-array'])->getStates());
        self::assertSame([$deviceConfigEntryForDashboardStateModel], $transformer->transform($base + [DeviceConfigurationDashboardTransformerInterface::KEY_STATES => [['test-nested'], 'test-skipped']])->getStates());
    }
}
