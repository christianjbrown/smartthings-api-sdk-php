<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

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
use ChristianBrown\SmartThings\Transformer\Action\ActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\ActionSequenceNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\ArrayOperandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\BetweenConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\ChangesConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\CommandActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\CommandSequenceNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\ConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\DateOperandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\DateTimeOperandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\DeviceOperandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\EqualsConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\EveryActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\GreaterThanConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\GreaterThanOrEqualsConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\IfActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\IfActionSequenceNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\IntervalNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\LessThanConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\LessThanOrEqualsConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\LimitActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\LocationActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\LocationOperandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistry;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryFactory;
use ChristianBrown\SmartThings\Transformer\Action\OperandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\RemainsConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\RuleDeviceCommandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SceneActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SceneArgumentNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SceneCapabilityNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SceneCommandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SceneComponentNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SceneDeviceGroupRequestNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SceneDeviceRequestNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SceneModeRequestNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SceneSleepRequestNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\SleepActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\TimeOperandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\ToggleActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\WasConditionNodeTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NodeTransformerRegistryFactory::class)]
#[UsesClass(NodeTransformerRegistry::class)]
final class NodeTransformerRegistryFactoryTest extends TestCase
{
    /**
     * @param class-string $type
     * @param class-string $transformer
     */
    #[DataProvider('provideCreateRegistersEveryTypeCases')]
    public function testCreateRegistersEveryType(string $type, string $transformer): void
    {
        $registry = (new NodeTransformerRegistryFactory())->create();

        self::assertInstanceOf($transformer, $registry->get($type));
    }

    /**
     * @return iterable<string, array{class-string, class-string}>
     */
    public static function provideCreateRegistersEveryTypeCases(): iterable
    {
        yield 'Action' => [ActionInterface::class, ActionNodeTransformer::class];

        yield 'ActionSequence' => [ActionSequenceInterface::class, ActionSequenceNodeTransformer::class];

        yield 'ArrayOperand' => [ArrayOperandInterface::class, ArrayOperandNodeTransformer::class];

        yield 'BetweenCondition' => [BetweenConditionInterface::class, BetweenConditionNodeTransformer::class];

        yield 'ChangesCondition' => [ChangesConditionInterface::class, ChangesConditionNodeTransformer::class];

        yield 'CommandAction' => [CommandActionInterface::class, CommandActionNodeTransformer::class];

        yield 'CommandSequence' => [CommandSequenceInterface::class, CommandSequenceNodeTransformer::class];

        yield 'Condition' => [ConditionInterface::class, ConditionNodeTransformer::class];

        yield 'DateOperand' => [DateOperandInterface::class, DateOperandNodeTransformer::class];

        yield 'DateTimeOperand' => [DateTimeOperandInterface::class, DateTimeOperandNodeTransformer::class];

        yield 'DeviceOperand' => [DeviceOperandInterface::class, DeviceOperandNodeTransformer::class];

        yield 'EqualsCondition' => [EqualsConditionInterface::class, EqualsConditionNodeTransformer::class];

        yield 'EveryAction' => [EveryActionInterface::class, EveryActionNodeTransformer::class];

        yield 'GreaterThanCondition' => [GreaterThanConditionInterface::class, GreaterThanConditionNodeTransformer::class];

        yield 'GreaterThanOrEqualsCondition' => [GreaterThanOrEqualsConditionInterface::class, GreaterThanOrEqualsConditionNodeTransformer::class];

        yield 'IfAction' => [IfActionInterface::class, IfActionNodeTransformer::class];

        yield 'IfActionSequence' => [IfActionSequenceInterface::class, IfActionSequenceNodeTransformer::class];

        yield 'Interval' => [IntervalInterface::class, IntervalNodeTransformer::class];

        yield 'LessThanCondition' => [LessThanConditionInterface::class, LessThanConditionNodeTransformer::class];

        yield 'LessThanOrEqualsCondition' => [LessThanOrEqualsConditionInterface::class, LessThanOrEqualsConditionNodeTransformer::class];

        yield 'LimitAction' => [LimitActionInterface::class, LimitActionNodeTransformer::class];

        yield 'LocationAction' => [LocationActionInterface::class, LocationActionNodeTransformer::class];

        yield 'LocationOperand' => [LocationOperandInterface::class, LocationOperandNodeTransformer::class];

        yield 'Operand' => [OperandInterface::class, OperandNodeTransformer::class];

        yield 'RemainsCondition' => [RemainsConditionInterface::class, RemainsConditionNodeTransformer::class];

        yield 'RuleDeviceCommand' => [RuleDeviceCommandInterface::class, RuleDeviceCommandNodeTransformer::class];

        yield 'SceneAction' => [SceneActionInterface::class, SceneActionNodeTransformer::class];

        yield 'SceneArgument' => [SceneArgumentInterface::class, SceneArgumentNodeTransformer::class];

        yield 'SceneCapability' => [SceneCapabilityInterface::class, SceneCapabilityNodeTransformer::class];

        yield 'SceneCommand' => [SceneCommandInterface::class, SceneCommandNodeTransformer::class];

        yield 'SceneComponent' => [SceneComponentInterface::class, SceneComponentNodeTransformer::class];

        yield 'SceneDeviceGroupRequest' => [SceneDeviceGroupRequestInterface::class, SceneDeviceGroupRequestNodeTransformer::class];

        yield 'SceneDeviceRequest' => [SceneDeviceRequestInterface::class, SceneDeviceRequestNodeTransformer::class];

        yield 'SceneModeRequest' => [SceneModeRequestInterface::class, SceneModeRequestNodeTransformer::class];

        yield 'SceneSleepRequest' => [SceneSleepRequestInterface::class, SceneSleepRequestNodeTransformer::class];

        yield 'SleepAction' => [SleepActionInterface::class, SleepActionNodeTransformer::class];

        yield 'TimeOperand' => [TimeOperandInterface::class, TimeOperandNodeTransformer::class];

        yield 'ToggleAction' => [ToggleActionInterface::class, ToggleActionNodeTransformer::class];

        yield 'WasCondition' => [WasConditionInterface::class, WasConditionNodeTransformer::class];
    }
}
