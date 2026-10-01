<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\Action;
use ChristianBrown\SmartThings\Model\ActionInterface;
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
use ChristianBrown\SmartThings\Serializer\ActionSerializerInterface;
use Closure;
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
final class ActionSerializerTest extends TestCase
{
    /**
     * The request is built inside the test, so the models are covered by it rather than by the provider.
     *
     * @param Closure(): ActionInterface $factory
     * @param array<array-key, mixed>    $expected
     */
    #[DataProvider('provideSerializeCases')]
    public function testSerialize(Closure $factory, array $expected): void
    {
        $serializer = new ActionSerializer((new NodeSerializerRegistryFactory())->create());

        self::assertSame($expected, $serializer->serialize($factory()));
    }

    /**
     * @return iterable<string, array{Closure(): ActionInterface, array<array-key, mixed>}>
     */
    public static function provideSerializeCases(): iterable
    {
        yield 'RequiredOnly' => self::serializeCase(
            static fn (): ActionInterface => new Action(),
            []
        );

        yield 'Action.if' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf(new IfAction()),
            [
                ActionSerializerInterface::KEY_IF => [],
            ]
        );

        yield 'Action.sleep' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setSleep(new SleepAction(new Interval(new Operand(), 'test-unit'))),
            [
                ActionSerializerInterface::KEY_SLEEP => [
                    ActionSerializerInterface::KEY_DURATION => [
                        ActionSerializerInterface::KEY_VALUE => [],
                        ActionSerializerInterface::KEY_UNIT => 'test-unit',
                    ],
                ],
            ]
        );

        yield 'Action.command' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setCommand(new CommandAction(['test-devices-1', 'test-devices-2'], [new RuleDeviceCommand('test-capability', 'test-command')])),
            [
                ActionSerializerInterface::KEY_COMMAND => [
                    ActionSerializerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionSerializerInterface::KEY_COMMANDS => [[
                        ActionSerializerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionSerializerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ]
        );

        yield 'Action.scene' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene(new SceneAction()),
            [
                ActionSerializerInterface::KEY_SCENE => [],
            ]
        );

        yield 'Action.every' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setEvery(new EveryAction([new Action()])),
            [
                ActionSerializerInterface::KEY_EVERY => [
                    ActionSerializerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'Action.location' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setLocation(new LocationAction()),
            [
                ActionSerializerInterface::KEY_LOCATION => [],
            ]
        );

        yield 'Action.limit' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setLimit(new LimitAction(7, 'test-period', [new Action()])),
            [
                ActionSerializerInterface::KEY_LIMIT => [
                    ActionSerializerInterface::KEY_COUNT => 7,
                    ActionSerializerInterface::KEY_PERIOD => 'test-period',
                    ActionSerializerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'Action.toggle' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setToggle(new ToggleAction(['test-devices-1', 'test-devices-2'], 'test-component', 'test-capability', 'test-attribute')),
            [
                ActionSerializerInterface::KEY_TOGGLE => [
                    ActionSerializerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionSerializerInterface::KEY_COMPONENT => 'test-component',
                    ActionSerializerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionSerializerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ]
        );

        yield 'IfAction.and' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([new Condition()])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[]],
                ],
            ]
        );

        yield 'IfAction.or' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setOr([new Condition()])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_OR => [[]],
                ],
            ]
        );

        yield 'IfAction.not' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setNot(new Condition())),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_NOT => [],
                ],
            ]
        );

        yield 'IfAction.equals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition(new Operand(), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.greaterThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setGreaterThan(new GreaterThanCondition(new Operand(), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_GREATER_THAN => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.greaterThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setGreaterThanOrEquals(new GreaterThanOrEqualsCondition(new Operand(), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.lessThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setLessThan(new LessThanCondition(new Operand(), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_LESS_THAN => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.lessThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setLessThanOrEquals(new LessThanOrEqualsCondition(new Operand(), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.between' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setBetween(new BetweenCondition(new Operand(), new Operand(), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_BETWEEN => [
                        ActionSerializerInterface::KEY_VALUE => [],
                        ActionSerializerInterface::KEY_START => [],
                        ActionSerializerInterface::KEY_END => [],
                    ],
                ],
            ]
        );

        yield 'IfAction.changes' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges(new ChangesCondition('test-id'))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'IfAction.remains' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains(new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'IfAction.was' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas(new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'IfAction.then' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setThen([new Action()])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_THEN => [[]],
                ],
            ]
        );

        yield 'IfAction.else' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setElse([new Action()])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_ELSE => [[]],
                ],
            ]
        );

        yield 'IfAction.sequence' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setSequence(new IfActionSequence())),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'Condition.and' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setAnd([new Condition()])])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_AND => [[]],
                    ]],
                ],
            ]
        );

        yield 'Condition.or' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setOr([new Condition()])])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_OR => [[]],
                    ]],
                ],
            ]
        );

        yield 'Condition.not' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setNot(new Condition())])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_NOT => [],
                    ]],
                ],
            ]
        );

        yield 'Condition.equals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setEquals(new EqualsCondition(new Operand(), new Operand()))])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.greaterThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setGreaterThan(new GreaterThanCondition(new Operand(), new Operand()))])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_GREATER_THAN => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.greaterThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setGreaterThanOrEquals(new GreaterThanOrEqualsCondition(new Operand(), new Operand()))])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.lessThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setLessThan(new LessThanCondition(new Operand(), new Operand()))])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_LESS_THAN => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.lessThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setLessThanOrEquals(new LessThanOrEqualsCondition(new Operand(), new Operand()))])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.between' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setBetween(new BetweenCondition(new Operand(), new Operand(), new Operand()))])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_BETWEEN => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_START => [],
                            ActionSerializerInterface::KEY_END => [],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.changes' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setChanges(new ChangesCondition('test-id'))])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_CHANGES => [
                            ActionSerializerInterface::KEY_ID => 'test-id',
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.remains' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setRemains(new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_REMAINS => [
                            ActionSerializerInterface::KEY_ID => 'test-id',
                            ActionSerializerInterface::KEY_DURATION => [
                                ActionSerializerInterface::KEY_VALUE => [],
                                ActionSerializerInterface::KEY_UNIT => 'test-unit',
                            ],
                        ],
                    ]],
                ],
            ]
        );

        yield 'Condition.was' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setAnd([(new Condition())
                        ->setWas(new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))])),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_AND => [[
                        ActionSerializerInterface::KEY_WAS => [
                            ActionSerializerInterface::KEY_ID => 'test-id',
                            ActionSerializerInterface::KEY_DURATION => [
                                ActionSerializerInterface::KEY_VALUE => [],
                                ActionSerializerInterface::KEY_UNIT => 'test-unit',
                            ],
                        ],
                    ]],
                ],
            ]
        );

        yield 'EqualsCondition.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals((new EqualsCondition(new Operand(), new Operand()))
                        ->setAggregation('test-aggregation')
                        ->setChangesOnly(true))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                        ActionSerializerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionSerializerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'Operand.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setBoolean(true)
                        ->setDecimal(1.5)
                        ->setInteger(7)
                        ->setString('test-string'), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_BOOLEAN => true,
                            ActionSerializerInterface::KEY_DECIMAL => 1.5,
                            ActionSerializerInterface::KEY_INTEGER => 7,
                            ActionSerializerInterface::KEY_STRING => 'test-string',
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.array' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setArray(new ArrayOperand([new Operand()])), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_ARRAY => [
                                ActionSerializerInterface::KEY_OPERANDS => [[]],
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.map' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setMap(['test-key' => new Operand()]), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_MAP => ['test-key' => []],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.device' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setDevice(new DeviceOperand(['test-devices-1', 'test-devices-2'], 'test-component', 'test-capability', 'test-attribute')), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_DEVICE => [
                                ActionSerializerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionSerializerInterface::KEY_COMPONENT => 'test-component',
                                ActionSerializerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionSerializerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.location' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setLocation(new LocationOperand('test-attribute')), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_LOCATION => [
                                ActionSerializerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.date' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setDate(new DateOperand()), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_DATE => [],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.time' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setTime(new TimeOperand('test-reference')), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_TIME => [
                                ActionSerializerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Operand.datetime' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setDatetime(new DateTimeOperand('test-reference')), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_DATETIME => [
                                ActionSerializerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'ArrayOperand.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setArray((new ArrayOperand([new Operand()]))
                            ->setAggregation('test-aggregation')), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_ARRAY => [
                                ActionSerializerInterface::KEY_OPERANDS => [[]],
                                ActionSerializerInterface::KEY_AGGREGATION => 'test-aggregation',
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setDevice((new DeviceOperand(['test-devices-1', 'test-devices-2'], 'test-component', 'test-capability', 'test-attribute'))
                            ->setPath('test-path')
                            ->setAggregation('test-aggregation')
                            ->setTrigger('test-trigger')), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_DEVICE => [
                                ActionSerializerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionSerializerInterface::KEY_COMPONENT => 'test-component',
                                ActionSerializerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionSerializerInterface::KEY_ATTRIBUTE => 'test-attribute',
                                ActionSerializerInterface::KEY_PATH => 'test-path',
                                ActionSerializerInterface::KEY_AGGREGATION => 'test-aggregation',
                                ActionSerializerInterface::KEY_TRIGGER => 'test-trigger',
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'LocationOperand.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setLocation((new LocationOperand('test-attribute'))
                            ->setLocationId('test-location-id')
                            ->setPostalCode('test-postal-code')
                            ->setTrigger('test-trigger')), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_LOCATION => [
                                ActionSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                                ActionSerializerInterface::KEY_POSTAL_CODE => 'test-postal-code',
                                ActionSerializerInterface::KEY_ATTRIBUTE => 'test-attribute',
                                ActionSerializerInterface::KEY_TRIGGER => 'test-trigger',
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DateOperand.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setDate((new DateOperand())
                            ->setTimeZoneId('test-time-zone-id')
                            ->setDaysOfWeek(['test-days-of-week-1', 'test-days-of-week-2'])
                            ->setYear(7)
                            ->setMonth(7)
                            ->setDay(7)
                            ->setReference('test-reference')), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_DATE => [
                                ActionSerializerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id',
                                ActionSerializerInterface::KEY_DAYS_OF_WEEK => ['test-days-of-week-1', 'test-days-of-week-2'],
                                ActionSerializerInterface::KEY_YEAR => 7,
                                ActionSerializerInterface::KEY_MONTH => 7,
                                ActionSerializerInterface::KEY_DAY => 7,
                                ActionSerializerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'TimeOperand.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setTime((new TimeOperand('test-reference'))
                            ->setTimeZoneId('test-time-zone-id')
                            ->setDaysOfWeek(['test-days-of-week-1', 'test-days-of-week-2'])), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_TIME => [
                                ActionSerializerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id',
                                ActionSerializerInterface::KEY_DAYS_OF_WEEK => ['test-days-of-week-1', 'test-days-of-week-2'],
                                ActionSerializerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'TimeOperand.offset' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setEquals(new EqualsCondition((new Operand())
                        ->setTime((new TimeOperand('test-reference'))
                            ->setOffset(new Interval(new Operand(), 'test-unit'))), new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [
                            ActionSerializerInterface::KEY_TIME => [
                                ActionSerializerInterface::KEY_REFERENCE => 'test-reference',
                                ActionSerializerInterface::KEY_OFFSET => [
                                    ActionSerializerInterface::KEY_VALUE => [],
                                    ActionSerializerInterface::KEY_UNIT => 'test-unit',
                                ],
                            ],
                        ],
                        ActionSerializerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DateTimeOperand.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setEvery((new EveryAction([new Action()]))
                    ->setSpecific((new DateTimeOperand('test-reference'))
                        ->setTimeZoneId('test-time-zone-id')
                        ->setLocationId('test-location-id')
                        ->setDaysOfWeek(['test-days-of-week-1', 'test-days-of-week-2'])
                        ->setYear(7)
                        ->setMonth(7)
                        ->setDay(7))),
            [
                ActionSerializerInterface::KEY_EVERY => [
                    ActionSerializerInterface::KEY_SPECIFIC => [
                        ActionSerializerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id',
                        ActionSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                        ActionSerializerInterface::KEY_DAYS_OF_WEEK => ['test-days-of-week-1', 'test-days-of-week-2'],
                        ActionSerializerInterface::KEY_YEAR => 7,
                        ActionSerializerInterface::KEY_MONTH => 7,
                        ActionSerializerInterface::KEY_DAY => 7,
                        ActionSerializerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionSerializerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.offset' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setEvery((new EveryAction([new Action()]))
                    ->setSpecific((new DateTimeOperand('test-reference'))
                        ->setOffset(new Interval(new Operand(), 'test-unit')))),
            [
                ActionSerializerInterface::KEY_EVERY => [
                    ActionSerializerInterface::KEY_SPECIFIC => [
                        ActionSerializerInterface::KEY_REFERENCE => 'test-reference',
                        ActionSerializerInterface::KEY_OFFSET => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                    ActionSerializerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'GreaterThanCondition.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setGreaterThan((new GreaterThanCondition(new Operand(), new Operand()))
                        ->setAggregation('test-aggregation')
                        ->setChangesOnly(true))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_GREATER_THAN => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                        ActionSerializerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionSerializerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'GreaterThanOrEqualsCondition.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setGreaterThanOrEquals((new GreaterThanOrEqualsCondition(new Operand(), new Operand()))
                        ->setAggregation('test-aggregation')
                        ->setChangesOnly(true))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                        ActionSerializerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionSerializerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'LessThanCondition.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setLessThan((new LessThanCondition(new Operand(), new Operand()))
                        ->setAggregation('test-aggregation')
                        ->setChangesOnly(true))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_LESS_THAN => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                        ActionSerializerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionSerializerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'LessThanOrEqualsCondition.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setLessThanOrEquals((new LessThanOrEqualsCondition(new Operand(), new Operand()))
                        ->setAggregation('test-aggregation')
                        ->setChangesOnly(true))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionSerializerInterface::KEY_LEFT => [],
                        ActionSerializerInterface::KEY_RIGHT => [],
                        ActionSerializerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionSerializerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'BetweenCondition.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setBetween((new BetweenCondition(new Operand(), new Operand(), new Operand()))
                        ->setAggregation('test-aggregation')
                        ->setChangesOnly(true))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_BETWEEN => [
                        ActionSerializerInterface::KEY_VALUE => [],
                        ActionSerializerInterface::KEY_START => [],
                        ActionSerializerInterface::KEY_END => [],
                        ActionSerializerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionSerializerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.and' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setAnd([new Condition()]))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_AND => [[]],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.or' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setOr([new Condition()]))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_OR => [[]],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.not' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setNot(new Condition()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_NOT => [],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.equals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setEquals(new EqualsCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.greaterThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setGreaterThan(new GreaterThanCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_GREATER_THAN => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.greaterThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setGreaterThanOrEquals(new GreaterThanOrEqualsCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.lessThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setLessThan(new LessThanCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_LESS_THAN => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.lessThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setLessThanOrEquals(new LessThanOrEqualsCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.between' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setBetween(new BetweenCondition(new Operand(), new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_BETWEEN => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_START => [],
                            ActionSerializerInterface::KEY_END => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.operand' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setChanges((new ChangesCondition('test-id'))
                        ->setOperand(new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_CHANGES => [
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_OPERAND => [],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setLatching(true))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                        ActionSerializerInterface::KEY_LATCHING => true,
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.and' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setAnd([new Condition()]))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_AND => [[]],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.or' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setOr([new Condition()]))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_OR => [[]],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.not' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setNot(new Condition()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_NOT => [],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.equals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setEquals(new EqualsCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.greaterThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setGreaterThan(new GreaterThanCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_GREATER_THAN => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.greaterThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setGreaterThanOrEquals(new GreaterThanOrEqualsCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.lessThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setLessThan(new LessThanCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_LESS_THAN => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.lessThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setLessThanOrEquals(new LessThanOrEqualsCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.between' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setBetween(new BetweenCondition(new Operand(), new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_BETWEEN => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_START => [],
                            ActionSerializerInterface::KEY_END => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.operand' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setRemains((new RemainsCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setOperand(new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_REMAINS => [
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_OPERAND => [],
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.and' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setAnd([new Condition()]))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_AND => [[]],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.or' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setOr([new Condition()]))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_OR => [[]],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.not' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setNot(new Condition()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_NOT => [],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.equals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setEquals(new EqualsCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.greaterThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setGreaterThan(new GreaterThanCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_GREATER_THAN => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.greaterThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setGreaterThanOrEquals(new GreaterThanOrEqualsCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.lessThan' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setLessThan(new LessThanCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_LESS_THAN => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.lessThanOrEquals' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setLessThanOrEquals(new LessThanOrEqualsCondition(new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionSerializerInterface::KEY_LEFT => [],
                            ActionSerializerInterface::KEY_RIGHT => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.between' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setBetween(new BetweenCondition(new Operand(), new Operand(), new Operand())))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_BETWEEN => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_START => [],
                            ActionSerializerInterface::KEY_END => [],
                        ],
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.operand' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setWas((new WasCondition('test-id', new Interval(new Operand(), 'test-unit')))
                        ->setOperand(new Operand()))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_WAS => [
                        ActionSerializerInterface::KEY_ID => 'test-id',
                        ActionSerializerInterface::KEY_DURATION => [
                            ActionSerializerInterface::KEY_VALUE => [],
                            ActionSerializerInterface::KEY_UNIT => 'test-unit',
                        ],
                        ActionSerializerInterface::KEY_OPERAND => [],
                    ],
                ],
            ]
        );

        yield 'IfActionSequence.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setIf((new IfAction())
                    ->setSequence((new IfActionSequence())
                        ->setThen('test-then')
                        ->setElse('test-else'))),
            [
                ActionSerializerInterface::KEY_IF => [
                    ActionSerializerInterface::KEY_SEQUENCE => [
                        ActionSerializerInterface::KEY_THEN => 'test-then',
                        ActionSerializerInterface::KEY_ELSE => 'test-else',
                    ],
                ],
            ]
        );

        yield 'CommandAction.sequence' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setCommand((new CommandAction(['test-devices-1', 'test-devices-2'], [new RuleDeviceCommand('test-capability', 'test-command')]))
                    ->setSequence(new CommandSequence())),
            [
                ActionSerializerInterface::KEY_COMMAND => [
                    ActionSerializerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionSerializerInterface::KEY_COMMANDS => [[
                        ActionSerializerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionSerializerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionSerializerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'RuleDeviceCommand.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setCommand(new CommandAction(['test-devices-1', 'test-devices-2'], [(new RuleDeviceCommand('test-capability', 'test-command'))
                    ->setComponent('test-component')
                    ->setArguments(['test-arguments-key' => 'test-value'])
                    ->setCommandId('test-command-id')])),
            [
                ActionSerializerInterface::KEY_COMMAND => [
                    ActionSerializerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionSerializerInterface::KEY_COMMANDS => [[
                        ActionSerializerInterface::KEY_COMPONENT => 'test-component',
                        ActionSerializerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionSerializerInterface::KEY_COMMAND => 'test-command',
                        ActionSerializerInterface::KEY_ARGUMENTS => ['test-arguments-key' => 'test-value'],
                        ActionSerializerInterface::KEY_COMMAND_ID => 'test-command-id',
                    ]],
                ],
            ]
        );

        yield 'CommandSequence.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setCommand((new CommandAction(['test-devices-1', 'test-devices-2'], [new RuleDeviceCommand('test-capability', 'test-command')]))
                    ->setSequence((new CommandSequence())
                        ->setCommands('test-commands')
                        ->setDevices('test-devices'))),
            [
                ActionSerializerInterface::KEY_COMMAND => [
                    ActionSerializerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionSerializerInterface::KEY_COMMANDS => [[
                        ActionSerializerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionSerializerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionSerializerInterface::KEY_SEQUENCE => [
                        ActionSerializerInterface::KEY_COMMANDS => 'test-commands',
                        ActionSerializerInterface::KEY_DEVICES => 'test-devices',
                    ],
                ],
            ]
        );

        yield 'SceneAction.deviceRequest' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceRequest(new SceneDeviceRequest())),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_REQUEST => [],
                ],
            ]
        );

        yield 'SceneAction.modeRequest' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setModeRequest(new SceneModeRequest('test-mode-id'))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_MODE_REQUEST => [
                        ActionSerializerInterface::KEY_MODE_ID => 'test-mode-id',
                    ],
                ],
            ]
        );

        yield 'SceneAction.sleepRequest' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setSleepRequest(new SceneSleepRequest(7))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_SLEEP_REQUEST => [
                        ActionSerializerInterface::KEY_SECONDS => 7,
                    ],
                ],
            ]
        );

        yield 'SceneAction.deviceGroupRequest' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceGroupRequest(new SceneDeviceGroupRequest('test-device-group-id'))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionSerializerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                    ],
                ],
            ]
        );

        yield 'SceneDeviceRequest.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceRequest((new SceneDeviceRequest())
                        ->setDeviceId('test-device-id')
                        ->setActionId('test-action-id'))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_REQUEST => [
                        ActionSerializerInterface::KEY_DEVICE_ID => 'test-device-id',
                        ActionSerializerInterface::KEY_ACTION_ID => 'test-action-id',
                    ],
                ],
            ]
        );

        yield 'SceneDeviceRequest.components' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceRequest((new SceneDeviceRequest())
                        ->setComponents([new SceneComponent()]))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_REQUEST => [
                        ActionSerializerInterface::KEY_COMPONENTS => [[]],
                    ],
                ],
            ]
        );

        yield 'SceneComponent.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceRequest((new SceneDeviceRequest())
                        ->setComponents([(new SceneComponent())
                            ->setComponentId('test-component-id')]))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_REQUEST => [
                        ActionSerializerInterface::KEY_COMPONENTS => [[
                            ActionSerializerInterface::KEY_COMPONENT_ID => 'test-component-id',
                        ]],
                    ],
                ],
            ]
        );
    }

    /**
     * Declared shape of a provider case, so the analyser does not accumulate every literal.
     *
     * @param Closure(): ActionInterface $factory
     * @param array<array-key, mixed>    $expected
     *
     * @return array{Closure(): ActionInterface, array<array-key, mixed>}
     */
    private static function serializeCase(Closure $factory, array $expected): array
    {
        return [$factory, $expected];
    }
}
