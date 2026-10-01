<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

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

/**
 * The composition root for serializing the Rule action tree: one entry per model type. A new type is a
 * new node serializer and one line here.
 */
final class NodeSerializerRegistryFactory implements NodeSerializerRegistryFactoryInterface
{
    public function create(): NodeSerializerRegistryInterface
    {
        return new NodeSerializerRegistry(
            [
                ActionInterface::class => new ActionNodeSerializer(),
                ActionSequenceInterface::class => new ActionSequenceNodeSerializer(),
                ArrayOperandInterface::class => new ArrayOperandNodeSerializer(),
                BetweenConditionInterface::class => new BetweenConditionNodeSerializer(),
                ChangesConditionInterface::class => new ChangesConditionNodeSerializer(),
                CommandActionInterface::class => new CommandActionNodeSerializer(),
                CommandSequenceInterface::class => new CommandSequenceNodeSerializer(),
                ConditionInterface::class => new ConditionNodeSerializer(),
                DateOperandInterface::class => new DateOperandNodeSerializer(),
                DateTimeOperandInterface::class => new DateTimeOperandNodeSerializer(),
                DeviceOperandInterface::class => new DeviceOperandNodeSerializer(),
                EqualsConditionInterface::class => new EqualsConditionNodeSerializer(),
                EveryActionInterface::class => new EveryActionNodeSerializer(),
                GreaterThanConditionInterface::class => new GreaterThanConditionNodeSerializer(),
                GreaterThanOrEqualsConditionInterface::class => new GreaterThanOrEqualsConditionNodeSerializer(),
                IfActionInterface::class => new IfActionNodeSerializer(),
                IfActionSequenceInterface::class => new IfActionSequenceNodeSerializer(),
                IntervalInterface::class => new IntervalNodeSerializer(),
                LessThanConditionInterface::class => new LessThanConditionNodeSerializer(),
                LessThanOrEqualsConditionInterface::class => new LessThanOrEqualsConditionNodeSerializer(),
                LimitActionInterface::class => new LimitActionNodeSerializer(),
                LocationActionInterface::class => new LocationActionNodeSerializer(),
                LocationOperandInterface::class => new LocationOperandNodeSerializer(),
                OperandInterface::class => new OperandNodeSerializer(),
                RemainsConditionInterface::class => new RemainsConditionNodeSerializer(),
                RuleDeviceCommandInterface::class => new RuleDeviceCommandNodeSerializer(),
                SceneActionInterface::class => new SceneActionNodeSerializer(),
                SceneArgumentInterface::class => new SceneArgumentNodeSerializer(),
                SceneCapabilityInterface::class => new SceneCapabilityNodeSerializer(),
                SceneCommandInterface::class => new SceneCommandNodeSerializer(),
                SceneComponentInterface::class => new SceneComponentNodeSerializer(),
                SceneDeviceGroupRequestInterface::class => new SceneDeviceGroupRequestNodeSerializer(),
                SceneDeviceRequestInterface::class => new SceneDeviceRequestNodeSerializer(),
                SceneModeRequestInterface::class => new SceneModeRequestNodeSerializer(),
                SceneSleepRequestInterface::class => new SceneSleepRequestNodeSerializer(),
                SleepActionInterface::class => new SleepActionNodeSerializer(),
                TimeOperandInterface::class => new TimeOperandNodeSerializer(),
                ToggleActionInterface::class => new ToggleActionNodeSerializer(),
                WasConditionInterface::class => new WasConditionNodeSerializer(),
            ]
        );
    }
}
