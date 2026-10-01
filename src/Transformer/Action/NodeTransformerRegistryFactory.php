<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

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
 * The composition root for the Rule action tree: one entry per model type. A new type is a new
 * node transformer and one line here.
 */
final class NodeTransformerRegistryFactory implements NodeTransformerRegistryFactoryInterface
{
    public function create(): NodeTransformerRegistryInterface
    {
        return new NodeTransformerRegistry(
            [
                ActionInterface::class => new ActionNodeTransformer(),
                ActionSequenceInterface::class => new ActionSequenceNodeTransformer(),
                ArrayOperandInterface::class => new ArrayOperandNodeTransformer(),
                BetweenConditionInterface::class => new BetweenConditionNodeTransformer(),
                ChangesConditionInterface::class => new ChangesConditionNodeTransformer(),
                CommandActionInterface::class => new CommandActionNodeTransformer(),
                CommandSequenceInterface::class => new CommandSequenceNodeTransformer(),
                ConditionInterface::class => new ConditionNodeTransformer(),
                DateOperandInterface::class => new DateOperandNodeTransformer(),
                DateTimeOperandInterface::class => new DateTimeOperandNodeTransformer(),
                DeviceOperandInterface::class => new DeviceOperandNodeTransformer(),
                EqualsConditionInterface::class => new EqualsConditionNodeTransformer(),
                EveryActionInterface::class => new EveryActionNodeTransformer(),
                GreaterThanConditionInterface::class => new GreaterThanConditionNodeTransformer(),
                GreaterThanOrEqualsConditionInterface::class => new GreaterThanOrEqualsConditionNodeTransformer(),
                IfActionInterface::class => new IfActionNodeTransformer(),
                IfActionSequenceInterface::class => new IfActionSequenceNodeTransformer(),
                IntervalInterface::class => new IntervalNodeTransformer(),
                LessThanConditionInterface::class => new LessThanConditionNodeTransformer(),
                LessThanOrEqualsConditionInterface::class => new LessThanOrEqualsConditionNodeTransformer(),
                LimitActionInterface::class => new LimitActionNodeTransformer(),
                LocationActionInterface::class => new LocationActionNodeTransformer(),
                LocationOperandInterface::class => new LocationOperandNodeTransformer(),
                OperandInterface::class => new OperandNodeTransformer(),
                RemainsConditionInterface::class => new RemainsConditionNodeTransformer(),
                RuleDeviceCommandInterface::class => new RuleDeviceCommandNodeTransformer(),
                SceneActionInterface::class => new SceneActionNodeTransformer(),
                SceneArgumentInterface::class => new SceneArgumentNodeTransformer(),
                SceneCapabilityInterface::class => new SceneCapabilityNodeTransformer(),
                SceneCommandInterface::class => new SceneCommandNodeTransformer(),
                SceneComponentInterface::class => new SceneComponentNodeTransformer(),
                SceneDeviceGroupRequestInterface::class => new SceneDeviceGroupRequestNodeTransformer(),
                SceneDeviceRequestInterface::class => new SceneDeviceRequestNodeTransformer(),
                SceneModeRequestInterface::class => new SceneModeRequestNodeTransformer(),
                SceneSleepRequestInterface::class => new SceneSleepRequestNodeTransformer(),
                SleepActionInterface::class => new SleepActionNodeTransformer(),
                TimeOperandInterface::class => new TimeOperandNodeTransformer(),
                ToggleActionInterface::class => new ToggleActionNodeTransformer(),
                WasConditionInterface::class => new WasConditionNodeTransformer(),
            ]
        );
    }
}
