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
use ChristianBrown\SmartThings\Serializer\ActionSerializer;
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
#[CoversClass(ActionSerializer::class)]
final class ActionTransformerLenientTest extends TestCase
{
    /**
     * @param array<array-key, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data): void
    {
        $transformer = new ActionTransformer();

        $transformer->transform($data);

        $this->addToAssertionCount(1);
    }

    /**
     * @return iterable<string, array{array<array-key, mixed>}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'EqualsCondition.left.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'EqualsCondition.left.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'EqualsCondition.right.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ]
        );

        yield 'EqualsCondition.right.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ]
        );

        yield 'ArrayOperand.operands.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'ArrayOperand.operands.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => [
                                ActionTransformerInterface::KEY_OPERANDS => 'not-array',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.devices.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
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

        yield 'DeviceOperand.devices.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => 'not-array',
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

        yield 'DeviceOperand.component.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.component.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 42,
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.capability.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.capability.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 42,
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.attribute.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DeviceOperand.attribute.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DEVICE => [
                                ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                                ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                                ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                                ActionTransformerInterface::KEY_ATTRIBUTE => 42,
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'LocationOperand.attribute.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'LocationOperand.attribute.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [
                                ActionTransformerInterface::KEY_ATTRIBUTE => 42,
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'TimeOperand.reference.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'TimeOperand.reference.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [
                                ActionTransformerInterface::KEY_REFERENCE => 42,
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'Interval.value.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_UNIT => 'test-unit',
                    ],
                ],
            ]
        );

        yield 'Interval.value.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_VALUE => 'not-array',
                        ActionTransformerInterface::KEY_UNIT => 'test-unit',
                    ],
                ],
            ]
        );

        yield 'Interval.unit.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_VALUE => [],
                    ],
                ],
            ]
        );

        yield 'Interval.unit.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_UNIT => 42,
                    ],
                ],
            ]
        );

        yield 'DateTimeOperand.reference.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.reference.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 42,
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'GreaterThanCondition.left.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'GreaterThanCondition.left.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'GreaterThanCondition.right.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ]
        );

        yield 'GreaterThanCondition.right.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ]
        );

        yield 'GreaterThanOrEqualsCondition.left.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'GreaterThanOrEqualsCondition.left.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'GreaterThanOrEqualsCondition.right.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ]
        );

        yield 'GreaterThanOrEqualsCondition.right.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ]
        );

        yield 'LessThanCondition.left.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'LessThanCondition.left.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'LessThanCondition.right.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ]
        );

        yield 'LessThanCondition.right.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ]
        );

        yield 'LessThanOrEqualsCondition.left.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'LessThanOrEqualsCondition.left.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'LessThanOrEqualsCondition.right.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ]
        );

        yield 'LessThanOrEqualsCondition.right.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ]
        );

        yield 'BetweenCondition.value.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ]
        );

        yield 'BetweenCondition.value.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => 'not-array',
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ]
        );

        yield 'BetweenCondition.start.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ]
        );

        yield 'BetweenCondition.start.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => 'not-array',
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ]
        );

        yield 'BetweenCondition.end.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                    ],
                ],
            ]
        );

        yield 'BetweenCondition.end.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => 'not-array',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.id.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [],
                ],
            ]
        );

        yield 'ChangesCondition.id.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_ID => 42,
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.id.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.id.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 42,
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.duration.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.duration.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => 'not-array',
                    ],
                ],
            ]
        );

        yield 'WasCondition.id.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.id.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_ID => 42,
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.duration.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'WasCondition.duration.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => 'not-array',
                    ],
                ],
            ]
        );

        yield 'SleepAction.duration.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [],
            ]
        );

        yield 'SleepAction.duration.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => 'not-array',
                ],
            ]
        );

        yield 'CommandAction.devices.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ]
        );

        yield 'CommandAction.devices.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => 'not-array',
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ]
        );

        yield 'CommandAction.commands.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                ],
            ]
        );

        yield 'CommandAction.commands.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => 'not-array',
                ],
            ]
        );

        yield 'RuleDeviceCommand.capability.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ]
        );

        yield 'RuleDeviceCommand.capability.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 42,
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ]
        );

        yield 'RuleDeviceCommand.command.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ]],
                ],
            ]
        );

        yield 'RuleDeviceCommand.command.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 42,
                    ]],
                ],
            ]
        );

        yield 'SceneModeRequest.modeId.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [],
                ],
            ]
        );

        yield 'SceneModeRequest.modeId.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 42,
                    ],
                ],
            ]
        );

        yield 'SceneSleepRequest.seconds.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_SLEEP_REQUEST => [],
                ],
            ]
        );

        yield 'SceneSleepRequest.seconds.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_SLEEP_REQUEST => [
                        ActionTransformerInterface::KEY_SECONDS => 'not-int',
                    ],
                ],
            ]
        );

        yield 'SceneDeviceGroupRequest.deviceGroupId.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [],
                ],
            ]
        );

        yield 'SceneDeviceGroupRequest.deviceGroupId.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 42,
                    ],
                ],
            ]
        );

        yield 'EveryAction.actions.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_EVERY => [],
            ]
        );

        yield 'EveryAction.actions.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => 'not-array',
                ],
            ]
        );

        yield 'LimitAction.count.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'LimitAction.count.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 'not-int',
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'LimitAction.period.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'LimitAction.period.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 42,
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'LimitAction.actions.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                ],
            ]
        );

        yield 'LimitAction.actions.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => 'not-array',
                ],
            ]
        );

        yield 'ToggleAction.devices.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ]
        );

        yield 'ToggleAction.devices.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => 'not-array',
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ]
        );

        yield 'ToggleAction.component.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ]
        );

        yield 'ToggleAction.component.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 42,
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ]
        );

        yield 'ToggleAction.capability.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ]
        );

        yield 'ToggleAction.capability.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 42,
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ]
        );

        yield 'ToggleAction.attribute.missing' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                ],
            ]
        );

        yield 'ToggleAction.attribute.wrongReq' => self::lenientCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 42,
                ],
            ]
        );
    }

    /**
     * @param array<array-key, mixed> $data
     *
     * @return array{array<array-key, mixed>}
     */
    private static function lenientCase(array $data): array
    {
        return [$data];
    }
}
