<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\Action;
use ChristianBrown\SmartThings\Model\ActionSequence;
use ChristianBrown\SmartThings\Model\ArrayOperand;
use ChristianBrown\SmartThings\Model\BetweenCondition;
use ChristianBrown\SmartThings\Model\ChangesCondition;
use ChristianBrown\SmartThings\Model\CommandAction;
use ChristianBrown\SmartThings\Model\CommandSequence;
use ChristianBrown\SmartThings\Model\Condition;
use ChristianBrown\SmartThings\Model\DateOperand;
use ChristianBrown\SmartThings\Model\DateTimeOperand;
use ChristianBrown\SmartThings\Model\DeviceOperand;
use ChristianBrown\SmartThings\Model\EqualsCondition;
use ChristianBrown\SmartThings\Model\EveryAction;
use ChristianBrown\SmartThings\Model\GreaterThanCondition;
use ChristianBrown\SmartThings\Model\GreaterThanOrEqualsCondition;
use ChristianBrown\SmartThings\Model\IfAction;
use ChristianBrown\SmartThings\Model\IfActionSequence;
use ChristianBrown\SmartThings\Model\Interval;
use ChristianBrown\SmartThings\Model\LessThanCondition;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsCondition;
use ChristianBrown\SmartThings\Model\LimitAction;
use ChristianBrown\SmartThings\Model\LocationAction;
use ChristianBrown\SmartThings\Model\LocationOperand;
use ChristianBrown\SmartThings\Model\Operand;
use ChristianBrown\SmartThings\Model\RemainsCondition;
use ChristianBrown\SmartThings\Model\RuleDeviceCommand;
use ChristianBrown\SmartThings\Model\SceneAction;
use ChristianBrown\SmartThings\Model\SceneArgument;
use ChristianBrown\SmartThings\Model\SceneCapability;
use ChristianBrown\SmartThings\Model\SceneCommand;
use ChristianBrown\SmartThings\Model\SceneComponent;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequest;
use ChristianBrown\SmartThings\Model\SceneDeviceRequest;
use ChristianBrown\SmartThings\Model\SceneModeRequest;
use ChristianBrown\SmartThings\Model\SceneSleepRequest;
use ChristianBrown\SmartThings\Model\SleepAction;
use ChristianBrown\SmartThings\Model\TimeOperand;
use ChristianBrown\SmartThings\Model\ToggleAction;
use ChristianBrown\SmartThings\Model\WasCondition;
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
use ChristianBrown\SmartThings\Serializer\ActionSerializer;
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
use ChristianBrown\SmartThings\Transformer\ActionTransformer;
use ChristianBrown\SmartThings\Transformer\ActionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Action::class)]
#[CoversClass(ActionSequence::class)]
#[CoversClass(ArrayOperand::class)]
#[CoversClass(BetweenCondition::class)]
#[CoversClass(ChangesCondition::class)]
#[CoversClass(CommandAction::class)]
#[CoversClass(CommandSequence::class)]
#[CoversClass(Condition::class)]
#[CoversClass(DateOperand::class)]
#[CoversClass(DateTimeOperand::class)]
#[CoversClass(DeviceOperand::class)]
#[CoversClass(EqualsCondition::class)]
#[CoversClass(EveryAction::class)]
#[CoversClass(GreaterThanCondition::class)]
#[CoversClass(GreaterThanOrEqualsCondition::class)]
#[CoversClass(IfAction::class)]
#[CoversClass(IfActionSequence::class)]
#[CoversClass(Interval::class)]
#[CoversClass(LessThanCondition::class)]
#[CoversClass(LessThanOrEqualsCondition::class)]
#[CoversClass(LimitAction::class)]
#[CoversClass(LocationAction::class)]
#[CoversClass(LocationOperand::class)]
#[CoversClass(Operand::class)]
#[CoversClass(RemainsCondition::class)]
#[CoversClass(RuleDeviceCommand::class)]
#[CoversClass(SceneAction::class)]
#[CoversClass(SceneArgument::class)]
#[CoversClass(SceneCapability::class)]
#[CoversClass(SceneCommand::class)]
#[CoversClass(SceneComponent::class)]
#[CoversClass(SceneDeviceGroupRequest::class)]
#[CoversClass(SceneDeviceRequest::class)]
#[CoversClass(SceneModeRequest::class)]
#[CoversClass(SceneSleepRequest::class)]
#[CoversClass(SleepAction::class)]
#[CoversClass(TimeOperand::class)]
#[CoversClass(ToggleAction::class)]
#[CoversClass(WasCondition::class)]
#[CoversClass(ActionTransformer::class)]
#[CoversClass(NodeTransformerRegistry::class)]
#[CoversClass(NodeTransformerRegistryFactory::class)]
#[CoversClass(ActionNodeTransformer::class)]
#[CoversClass(ActionSequenceNodeTransformer::class)]
#[CoversClass(ArrayOperandNodeTransformer::class)]
#[CoversClass(BetweenConditionNodeTransformer::class)]
#[CoversClass(ChangesConditionNodeTransformer::class)]
#[CoversClass(CommandActionNodeTransformer::class)]
#[CoversClass(CommandSequenceNodeTransformer::class)]
#[CoversClass(ConditionNodeTransformer::class)]
#[CoversClass(DateOperandNodeTransformer::class)]
#[CoversClass(DateTimeOperandNodeTransformer::class)]
#[CoversClass(DeviceOperandNodeTransformer::class)]
#[CoversClass(EqualsConditionNodeTransformer::class)]
#[CoversClass(EveryActionNodeTransformer::class)]
#[CoversClass(GreaterThanConditionNodeTransformer::class)]
#[CoversClass(GreaterThanOrEqualsConditionNodeTransformer::class)]
#[CoversClass(IfActionNodeTransformer::class)]
#[CoversClass(IfActionSequenceNodeTransformer::class)]
#[CoversClass(IntervalNodeTransformer::class)]
#[CoversClass(LessThanConditionNodeTransformer::class)]
#[CoversClass(LessThanOrEqualsConditionNodeTransformer::class)]
#[CoversClass(LimitActionNodeTransformer::class)]
#[CoversClass(LocationActionNodeTransformer::class)]
#[CoversClass(LocationOperandNodeTransformer::class)]
#[CoversClass(OperandNodeTransformer::class)]
#[CoversClass(RemainsConditionNodeTransformer::class)]
#[CoversClass(RuleDeviceCommandNodeTransformer::class)]
#[CoversClass(SceneActionNodeTransformer::class)]
#[CoversClass(SceneArgumentNodeTransformer::class)]
#[CoversClass(SceneCapabilityNodeTransformer::class)]
#[CoversClass(SceneCommandNodeTransformer::class)]
#[CoversClass(SceneComponentNodeTransformer::class)]
#[CoversClass(SceneDeviceGroupRequestNodeTransformer::class)]
#[CoversClass(SceneDeviceRequestNodeTransformer::class)]
#[CoversClass(SceneModeRequestNodeTransformer::class)]
#[CoversClass(SceneSleepRequestNodeTransformer::class)]
#[CoversClass(SleepActionNodeTransformer::class)]
#[CoversClass(TimeOperandNodeTransformer::class)]
#[CoversClass(ToggleActionNodeTransformer::class)]
#[CoversClass(WasConditionNodeTransformer::class)]
#[CoversClass(ActionSerializer::class)]
#[CoversClass(NodeSerializerRegistry::class)]
#[CoversClass(NodeSerializerRegistryFactory::class)]
#[CoversClass(ActionNodeSerializer::class)]
#[CoversClass(ActionSequenceNodeSerializer::class)]
#[CoversClass(ArrayOperandNodeSerializer::class)]
#[CoversClass(BetweenConditionNodeSerializer::class)]
#[CoversClass(ChangesConditionNodeSerializer::class)]
#[CoversClass(CommandActionNodeSerializer::class)]
#[CoversClass(CommandSequenceNodeSerializer::class)]
#[CoversClass(ConditionNodeSerializer::class)]
#[CoversClass(DateOperandNodeSerializer::class)]
#[CoversClass(DateTimeOperandNodeSerializer::class)]
#[CoversClass(DeviceOperandNodeSerializer::class)]
#[CoversClass(EqualsConditionNodeSerializer::class)]
#[CoversClass(EveryActionNodeSerializer::class)]
#[CoversClass(GreaterThanConditionNodeSerializer::class)]
#[CoversClass(GreaterThanOrEqualsConditionNodeSerializer::class)]
#[CoversClass(IfActionNodeSerializer::class)]
#[CoversClass(IfActionSequenceNodeSerializer::class)]
#[CoversClass(IntervalNodeSerializer::class)]
#[CoversClass(LessThanConditionNodeSerializer::class)]
#[CoversClass(LessThanOrEqualsConditionNodeSerializer::class)]
#[CoversClass(LimitActionNodeSerializer::class)]
#[CoversClass(LocationActionNodeSerializer::class)]
#[CoversClass(LocationOperandNodeSerializer::class)]
#[CoversClass(OperandNodeSerializer::class)]
#[CoversClass(RemainsConditionNodeSerializer::class)]
#[CoversClass(RuleDeviceCommandNodeSerializer::class)]
#[CoversClass(SceneActionNodeSerializer::class)]
#[CoversClass(SceneArgumentNodeSerializer::class)]
#[CoversClass(SceneCapabilityNodeSerializer::class)]
#[CoversClass(SceneCommandNodeSerializer::class)]
#[CoversClass(SceneComponentNodeSerializer::class)]
#[CoversClass(SceneDeviceGroupRequestNodeSerializer::class)]
#[CoversClass(SceneDeviceRequestNodeSerializer::class)]
#[CoversClass(SceneModeRequestNodeSerializer::class)]
#[CoversClass(SceneSleepRequestNodeSerializer::class)]
#[CoversClass(SleepActionNodeSerializer::class)]
#[CoversClass(TimeOperandNodeSerializer::class)]
#[CoversClass(ToggleActionNodeSerializer::class)]
#[CoversClass(WasConditionNodeSerializer::class)]
final class ActionTransformerTest extends TestCase
{
    /**
     * Each provider case is an input and the normalised form it must round-trip to through the serializer.
     *
     * @param array<array-key, mixed> $data
     * @param array<array-key, mixed> $expected
     */
    #[DataProvider('provideTransformCases')]
    public function testTransform(array $data, array $expected): void
    {
        $transformer = new ActionTransformer((new NodeTransformerRegistryFactory())->create());

        $actual = $transformer->transform($data);

        self::assertSame($expected, (new ActionSerializer((new NodeSerializerRegistryFactory())->create()))->serialize($actual));
    }

    /**
     * @return iterable<string, array{array<array-key, mixed>, array<array-key, mixed>}>
     */
    public static function provideTransformCases(): iterable
    {
        yield 'RequiredOnly' => self::transformCase(
            [],
            []
        );

        yield 'Action.if' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'Action.if.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => 'not-array',
            ],
            []
        );

        yield 'Action.sleep' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_UNIT => 'test-unit',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_UNIT => 'test-unit',
                    ],
                ],
            ]
        );

        yield 'Action.sleep.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SLEEP => 'not-array',
            ],
            []
        );

        yield 'Action.command' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ]
        );

        yield 'Action.command.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => 'not-array',
            ],
            []
        );

        yield 'Action.scene' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [],
            ]
        );

        yield 'Action.scene.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => 'not-array',
            ],
            []
        );

        yield 'Action.every' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'Action.every.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => 'not-array',
            ],
            []
        );

        yield 'Action.location' => self::transformCase(
            [
                ActionTransformerInterface::KEY_LOCATION => [],
            ],
            [
                ActionTransformerInterface::KEY_LOCATION => [],
            ]
        );

        yield 'Action.location.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_LOCATION => 'not-array',
            ],
            []
        );

        yield 'Action.limit' => self::transformCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'Action.limit.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_LIMIT => 'not-array',
            ],
            []
        );

        yield 'Action.toggle' => self::transformCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ],
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ]
        );

        yield 'Action.toggle.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => 'not-array',
            ],
            []
        );

        yield 'IfAction.and' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[], 'test-skipped'],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'IfAction.and.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.or' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_OR => [[], 'test-skipped'],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_OR => [[]],
                ],
            ]
        );

        yield 'IfAction.or.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_OR => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.not' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_NOT => [],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_NOT => [],
                ],
            ]
        );

        yield 'IfAction.not.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_NOT => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.equals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.equals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.greaterThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.greaterThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.greaterThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.greaterThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.lessThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.lessThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.lessThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.lessThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.between' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.between.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.changes' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'IfAction.changes.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.remains' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'IfAction.remains.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.was' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'IfAction.was.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.then' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_THEN => [[], 'test-skipped'],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_THEN => [[]],
                ],
            ]
        );

        yield 'IfAction.then.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_THEN => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.else' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_ELSE => [[], 'test-skipped'],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_ELSE => [[]],
                ],
            ]
        );

        yield 'IfAction.else.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_ELSE => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'IfAction.sequence' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'IfAction.sequence.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_SEQUENCE => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [],
            ]
        );

        yield 'Condition.and' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_AND => [[], 'test-skipped'],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_AND => [[]],
                    ]],
                ],
            ]
        );

        yield 'Condition.and.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_AND => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.or' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_OR => [[], 'test-skipped'],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_OR => [[]],
                    ]],
                ],
            ]
        );

        yield 'Condition.or.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_OR => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.not' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_NOT => [],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_NOT => [],
                    ]],
                ],
            ]
        );

        yield 'Condition.not.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_NOT => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.equals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.equals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_EQUALS => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.greaterThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_GREATER_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_GREATER_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.greaterThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_GREATER_THAN => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.greaterThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.greaterThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.lessThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_LESS_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_LESS_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.lessThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_LESS_THAN => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.lessThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.lessThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.between' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_BETWEEN => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_START => [],
                            ActionTransformerInterface::KEY_END => [],
                        ],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_BETWEEN => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_START => [],
                            ActionTransformerInterface::KEY_END => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.between.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_BETWEEN => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.changes' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_CHANGES => [
                            ActionTransformerInterface::KEY_ID => 'test-id',
                        ],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_CHANGES => [
                            ActionTransformerInterface::KEY_ID => 'test-id',
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.changes.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_CHANGES => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.remains' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_REMAINS => [
                            ActionTransformerInterface::KEY_ID => 'test-id',
                            ActionTransformerInterface::KEY_DURATION => [
                                ActionTransformerInterface::KEY_VALUE => [],
                                ActionTransformerInterface::KEY_UNIT => 'test-unit',
                            ],
                        ],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_REMAINS => [
                            ActionTransformerInterface::KEY_ID => 'test-id',
                            ActionTransformerInterface::KEY_DURATION => [
                                ActionTransformerInterface::KEY_VALUE => [],
                                ActionTransformerInterface::KEY_UNIT => 'test-unit',
                            ],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.remains.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_REMAINS => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'Condition.was' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_WAS => [
                            ActionTransformerInterface::KEY_ID => 'test-id',
                            ActionTransformerInterface::KEY_DURATION => [
                                ActionTransformerInterface::KEY_VALUE => [],
                                ActionTransformerInterface::KEY_UNIT => 'test-unit',
                            ],
                        ],
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_WAS => [
                            ActionTransformerInterface::KEY_ID => 'test-id',
                            ActionTransformerInterface::KEY_DURATION => [
                                ActionTransformerInterface::KEY_VALUE => [],
                                ActionTransformerInterface::KEY_UNIT => 'test-unit',
                            ],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.was.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[
                        ActionTransformerInterface::KEY_WAS => 'not-array',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'EqualsCondition.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'EqualsCondition.aggregation.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'EqualsCondition.changesOnly.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_CHANGES_ONLY => 'not-bool',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_BOOLEAN => true,
                            ActionTransformerInterface::KEY_DECIMAL => 1.5,
                            ActionTransformerInterface::KEY_INTEGER => 7,
                            ActionTransformerInterface::KEY_STRING => 'test-string',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_BOOLEAN => true,
                            ActionTransformerInterface::KEY_DECIMAL => 1.5,
                            ActionTransformerInterface::KEY_INTEGER => 7,
                            ActionTransformerInterface::KEY_STRING => 'test-string',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.boolean.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_BOOLEAN => 'not-bool',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.decimal.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DECIMAL => 'not-number',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.integer.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_INTEGER => 'not-int',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.string.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_STRING => 42,
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.array' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => [
                                ActionTransformerInterface::KEY_OPERANDS => [[]],
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => [
                                ActionTransformerInterface::KEY_OPERANDS => [[]],
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.array.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => 'not-array',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.map' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_MAP => ['test-key' => [], 'test-skipped' => 'not-array'],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_MAP => ['test-key' => []],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.map.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_MAP => 'not-array',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.device' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.device.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => 'not-array',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.location' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.location.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => 'not-array',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.date' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.date.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => 'not-array',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.time' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [
                                ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [
                                ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.time.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => 'not-array',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.datetime' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATETIME => [
                                ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATETIME => [
                                ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.datetime.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATETIME => 'not-array',
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'ArrayOperand.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => [
                                ActionTransformerInterface::KEY_OPERANDS => [[]],
                                ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => [
                                ActionTransformerInterface::KEY_OPERANDS => [[]],
                                ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'ArrayOperand.aggregation.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => [
                                ActionTransformerInterface::KEY_OPERANDS => [[]],
                                ActionTransformerInterface::KEY_AGGREGATION => 42,
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => [
                                ActionTransformerInterface::KEY_OPERANDS => [[]],
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                                ActionTransformerInterface::KEY_PATH => 'test-path',
                                ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                                ActionTransformerInterface::KEY_TRIGGER => 'test-trigger',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                                ActionTransformerInterface::KEY_PATH => 'test-path',
                                ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                                ActionTransformerInterface::KEY_TRIGGER => 'test-trigger',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.path.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                                ActionTransformerInterface::KEY_PATH => 42,
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.aggregation.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                                ActionTransformerInterface::KEY_AGGREGATION => 42,
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.trigger.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                                ActionTransformerInterface::KEY_TRIGGER => 42,
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'LocationOperand.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [
                                ActionTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
                                ActionTransformerInterface::KEY_POSTAL_CODE => 'test-postal-code',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                                ActionTransformerInterface::KEY_TRIGGER => 'test-trigger',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [
                                ActionTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
                                ActionTransformerInterface::KEY_POSTAL_CODE => 'test-postal-code',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                                ActionTransformerInterface::KEY_TRIGGER => 'test-trigger',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );
    }

    public function testTransformActionSequence(): void
    {
        $transformer = new ActionTransformer((new NodeTransformerRegistryFactory())->create());
        $data = [];

        $transformer->transformActionSequence($data);
        $transformer->transformAllActionSequence([$data]);
        $transformer->transformMapActionSequence(['test-key' => $data]);

        $this->addToAssertionCount(1);
    }

    public function testTransformAll(): void
    {
        $transformer = new ActionTransformer((new NodeTransformerRegistryFactory())->create());

        $data = [];

        $actual = $transformer->transformAll([$data, 'test-not-array', $data]);

        self::assertCount(2, $actual);
        self::assertCount(1, $transformer->transformMap(['test-key' => $data, 'test-skipped' => 'test-not-array']));
    }

    /**
     * Declared shape of a provider case, so the analyser does not accumulate every literal.
     *
     * @param array<array-key, mixed> $data
     * @param array<array-key, mixed> $expected
     *
     * @return array{array<array-key, mixed>, array<array-key, mixed>}
     */
    private static function transformCase(array $data, array $expected): array
    {
        return [$data, $expected];
    }
}
