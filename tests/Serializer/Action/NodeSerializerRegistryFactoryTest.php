<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer\Action;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Model\ArrayOperandInterface;
use ChristianBrown\SmartThings\Model\BetweenConditionInterface;
use ChristianBrown\SmartThings\Model\ChangesConditionInterface;
use ChristianBrown\SmartThings\Model\CommandActionInterface;
use ChristianBrown\SmartThings\Model\CommandSequenceInterface;
use ChristianBrown\SmartThings\Model\ConditionInterface;
use ChristianBrown\SmartThings\Model\DateOperandInterface;
use ChristianBrown\SmartThings\Model\DateTimeOperandInterface;
use ChristianBrown\SmartThings\Model\DeviceOperandInterface;
use ChristianBrown\SmartThings\Model\EqualsConditionInterface;
use ChristianBrown\SmartThings\Model\EveryActionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanConditionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\IfActionInterface;
use ChristianBrown\SmartThings\Model\IfActionSequenceInterface;
use ChristianBrown\SmartThings\Model\IntervalInterface;
use ChristianBrown\SmartThings\Model\LessThanConditionInterface;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\LimitActionInterface;
use ChristianBrown\SmartThings\Model\LocationActionInterface;
use ChristianBrown\SmartThings\Model\LocationOperandInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;
use ChristianBrown\SmartThings\Model\RemainsConditionInterface;
use ChristianBrown\SmartThings\Model\RuleDeviceCommandInterface;
use ChristianBrown\SmartThings\Model\SceneActionInterface;
use ChristianBrown\SmartThings\Model\SceneArgumentInterface;
use ChristianBrown\SmartThings\Model\SceneCapabilityInterface;
use ChristianBrown\SmartThings\Model\SceneCommandInterface;
use ChristianBrown\SmartThings\Model\SceneComponentInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequestInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceRequestInterface;
use ChristianBrown\SmartThings\Model\SceneModeRequestInterface;
use ChristianBrown\SmartThings\Model\SceneSleepRequestInterface;
use ChristianBrown\SmartThings\Model\SleepActionInterface;
use ChristianBrown\SmartThings\Model\TimeOperandInterface;
use ChristianBrown\SmartThings\Model\ToggleActionInterface;
use ChristianBrown\SmartThings\Model\WasConditionInterface;
use ChristianBrown\SmartThings\Serializer\Action\ActionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\ActionSequenceNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\ArrayOperandNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\BetweenConditionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\ChangesConditionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\CommandActionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\CommandSequenceNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\ConditionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\DateOperandNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\DateTimeOperandNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\DeviceOperandNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\EqualsConditionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\EveryActionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\GreaterThanConditionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\GreaterThanOrEqualsConditionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\IfActionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\IfActionSequenceNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\IntervalNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\LessThanConditionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\LessThanOrEqualsConditionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\LimitActionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\LocationActionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\LocationOperandNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\NodeSerializerRegistry;
use ChristianBrown\SmartThings\Serializer\Action\NodeSerializerRegistryFactory;
use ChristianBrown\SmartThings\Serializer\Action\OperandNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\RemainsConditionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\RuleDeviceCommandNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SceneActionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SceneArgumentNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SceneCapabilityNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SceneCommandNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SceneComponentNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SceneDeviceGroupRequestNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SceneDeviceRequestNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SceneModeRequestNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SceneSleepRequestNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\SleepActionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\TimeOperandNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\ToggleActionNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\WasConditionNodeSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NodeSerializerRegistryFactory::class)]
#[UsesClass(NodeSerializerRegistry::class)]
final class NodeSerializerRegistryFactoryTest extends TestCase
{
    /**
     * @param class-string $type
     * @param class-string $serializer
     */
    #[DataProvider('provideCreateRegistersEveryTypeCases')]
    public function testCreateRegistersEveryType(string $type, string $serializer): void
    {
        $registry = (new NodeSerializerRegistryFactory())->create();

        self::assertInstanceOf($serializer, $registry->get($type));
    }

    /**
     * @return iterable<string, array{class-string, class-string}>
     */
    public static function provideCreateRegistersEveryTypeCases(): iterable
    {
        yield 'Action' => [ActionInterface::class, ActionNodeSerializer::class];

        yield 'ActionSequence' => [ActionSequenceInterface::class, ActionSequenceNodeSerializer::class];

        yield 'ArrayOperand' => [ArrayOperandInterface::class, ArrayOperandNodeSerializer::class];

        yield 'BetweenCondition' => [BetweenConditionInterface::class, BetweenConditionNodeSerializer::class];

        yield 'ChangesCondition' => [ChangesConditionInterface::class, ChangesConditionNodeSerializer::class];

        yield 'CommandAction' => [CommandActionInterface::class, CommandActionNodeSerializer::class];

        yield 'CommandSequence' => [CommandSequenceInterface::class, CommandSequenceNodeSerializer::class];

        yield 'Condition' => [ConditionInterface::class, ConditionNodeSerializer::class];

        yield 'DateOperand' => [DateOperandInterface::class, DateOperandNodeSerializer::class];

        yield 'DateTimeOperand' => [DateTimeOperandInterface::class, DateTimeOperandNodeSerializer::class];

        yield 'DeviceOperand' => [DeviceOperandInterface::class, DeviceOperandNodeSerializer::class];

        yield 'EqualsCondition' => [EqualsConditionInterface::class, EqualsConditionNodeSerializer::class];

        yield 'EveryAction' => [EveryActionInterface::class, EveryActionNodeSerializer::class];

        yield 'GreaterThanCondition' => [GreaterThanConditionInterface::class, GreaterThanConditionNodeSerializer::class];

        yield 'GreaterThanOrEqualsCondition' => [GreaterThanOrEqualsConditionInterface::class, GreaterThanOrEqualsConditionNodeSerializer::class];

        yield 'IfAction' => [IfActionInterface::class, IfActionNodeSerializer::class];

        yield 'IfActionSequence' => [IfActionSequenceInterface::class, IfActionSequenceNodeSerializer::class];

        yield 'Interval' => [IntervalInterface::class, IntervalNodeSerializer::class];

        yield 'LessThanCondition' => [LessThanConditionInterface::class, LessThanConditionNodeSerializer::class];

        yield 'LessThanOrEqualsCondition' => [LessThanOrEqualsConditionInterface::class, LessThanOrEqualsConditionNodeSerializer::class];

        yield 'LimitAction' => [LimitActionInterface::class, LimitActionNodeSerializer::class];

        yield 'LocationAction' => [LocationActionInterface::class, LocationActionNodeSerializer::class];

        yield 'LocationOperand' => [LocationOperandInterface::class, LocationOperandNodeSerializer::class];

        yield 'Operand' => [OperandInterface::class, OperandNodeSerializer::class];

        yield 'RemainsCondition' => [RemainsConditionInterface::class, RemainsConditionNodeSerializer::class];

        yield 'RuleDeviceCommand' => [RuleDeviceCommandInterface::class, RuleDeviceCommandNodeSerializer::class];

        yield 'SceneAction' => [SceneActionInterface::class, SceneActionNodeSerializer::class];

        yield 'SceneArgument' => [SceneArgumentInterface::class, SceneArgumentNodeSerializer::class];

        yield 'SceneCapability' => [SceneCapabilityInterface::class, SceneCapabilityNodeSerializer::class];

        yield 'SceneCommand' => [SceneCommandInterface::class, SceneCommandNodeSerializer::class];

        yield 'SceneComponent' => [SceneComponentInterface::class, SceneComponentNodeSerializer::class];

        yield 'SceneDeviceGroupRequest' => [SceneDeviceGroupRequestInterface::class, SceneDeviceGroupRequestNodeSerializer::class];

        yield 'SceneDeviceRequest' => [SceneDeviceRequestInterface::class, SceneDeviceRequestNodeSerializer::class];

        yield 'SceneModeRequest' => [SceneModeRequestInterface::class, SceneModeRequestNodeSerializer::class];

        yield 'SceneSleepRequest' => [SceneSleepRequestInterface::class, SceneSleepRequestNodeSerializer::class];

        yield 'SleepAction' => [SleepActionInterface::class, SleepActionNodeSerializer::class];

        yield 'TimeOperand' => [TimeOperandInterface::class, TimeOperandNodeSerializer::class];

        yield 'ToggleAction' => [ToggleActionInterface::class, ToggleActionNodeSerializer::class];

        yield 'WasCondition' => [WasConditionInterface::class, WasConditionNodeSerializer::class];
    }
}
