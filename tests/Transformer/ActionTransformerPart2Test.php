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
final class ActionTransformerPart2Test extends TestCase
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

        self::assertSame($expected, (new ActionSerializer())->serialize($actual));
    }

    /**
     * @return iterable<string, array{array<array-key, mixed>, array<array-key, mixed>}>
     */
    public static function provideTransformCases(): iterable
    {
        yield 'LocationOperand.locationId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [
                                ActionTransformerInterface::KEY_LOCATION_ID => 42,
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

        yield 'LocationOperand.postalCode.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [
                                ActionTransformerInterface::KEY_POSTAL_CODE => 42,
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

        yield 'LocationOperand.trigger.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [
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
                            ActionTransformerInterface::KEY_LOCATION => [
                                ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DateOperand.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => [
                                ActionTransformerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id',
                                ActionTransformerInterface::KEY_DAYS_OF_WEEK => ['test-days-of-week-1', 'test-days-of-week-2'],
                                ActionTransformerInterface::KEY_YEAR => 7,
                                ActionTransformerInterface::KEY_MONTH => 7,
                                ActionTransformerInterface::KEY_DAY => 7,
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
                            ActionTransformerInterface::KEY_DATE => [
                                ActionTransformerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id',
                                ActionTransformerInterface::KEY_DAYS_OF_WEEK => ['test-days-of-week-1', 'test-days-of-week-2'],
                                ActionTransformerInterface::KEY_YEAR => 7,
                                ActionTransformerInterface::KEY_MONTH => 7,
                                ActionTransformerInterface::KEY_DAY => 7,
                                ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DateOperand.timeZoneId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => [
                                ActionTransformerInterface::KEY_TIME_ZONE_ID => 42,
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
                            ActionTransformerInterface::KEY_DATE => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DateOperand.daysOfWeek.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => [
                                ActionTransformerInterface::KEY_DAYS_OF_WEEK => 'not-array',
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
                            ActionTransformerInterface::KEY_DATE => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DateOperand.year.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => [
                                ActionTransformerInterface::KEY_YEAR => 'not-int',
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
                            ActionTransformerInterface::KEY_DATE => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DateOperand.month.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => [
                                ActionTransformerInterface::KEY_MONTH => 'not-int',
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
                            ActionTransformerInterface::KEY_DATE => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DateOperand.day.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => [
                                ActionTransformerInterface::KEY_DAY => 'not-int',
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
                            ActionTransformerInterface::KEY_DATE => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'DateOperand.reference.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_DATE => [
                                ActionTransformerInterface::KEY_REFERENCE => 42,
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
                            ActionTransformerInterface::KEY_DATE => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'TimeOperand.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [
                                ActionTransformerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id',
                                ActionTransformerInterface::KEY_DAYS_OF_WEEK => ['test-days-of-week-1', 'test-days-of-week-2'],
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
                                ActionTransformerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id',
                                ActionTransformerInterface::KEY_DAYS_OF_WEEK => ['test-days-of-week-1', 'test-days-of-week-2'],
                                ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'TimeOperand.timeZoneId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [
                                ActionTransformerInterface::KEY_TIME_ZONE_ID => 42,
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

        yield 'TimeOperand.daysOfWeek.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [
                                ActionTransformerInterface::KEY_DAYS_OF_WEEK => 'not-array',
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

        yield 'TimeOperand.offset' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [
                                ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                                ActionTransformerInterface::KEY_OFFSET => [
                                    ActionTransformerInterface::KEY_VALUE => [],
                                    ActionTransformerInterface::KEY_UNIT => 'test-unit',
                                ],
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
                                ActionTransformerInterface::KEY_OFFSET => [
                                    ActionTransformerInterface::KEY_VALUE => [],
                                    ActionTransformerInterface::KEY_UNIT => 'test-unit',
                                ],
                            ],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ]
        );

        yield 'TimeOperand.offset.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [
                                ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                                ActionTransformerInterface::KEY_OFFSET => 'not-array',
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

        yield 'DateTimeOperand.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id',
                        ActionTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
                        ActionTransformerInterface::KEY_DAYS_OF_WEEK => ['test-days-of-week-1', 'test-days-of-week-2'],
                        ActionTransformerInterface::KEY_YEAR => 7,
                        ActionTransformerInterface::KEY_MONTH => 7,
                        ActionTransformerInterface::KEY_DAY => 7,
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id',
                        ActionTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
                        ActionTransformerInterface::KEY_DAYS_OF_WEEK => ['test-days-of-week-1', 'test-days-of-week-2'],
                        ActionTransformerInterface::KEY_YEAR => 7,
                        ActionTransformerInterface::KEY_MONTH => 7,
                        ActionTransformerInterface::KEY_DAY => 7,
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.timeZoneId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_TIME_ZONE_ID => 42,
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.locationId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_LOCATION_ID => 42,
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.daysOfWeek.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_DAYS_OF_WEEK => 'not-array',
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.year.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_YEAR => 'not-int',
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.month.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_MONTH => 'not-int',
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.day.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_DAY => 'not-int',
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.offset' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                        ActionTransformerInterface::KEY_OFFSET => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                        ActionTransformerInterface::KEY_OFFSET => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'DateTimeOperand.offset.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                        ActionTransformerInterface::KEY_OFFSET => 'not-array',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'GreaterThanCondition.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'GreaterThanCondition.aggregation.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 42,
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

        yield 'GreaterThanCondition.changesOnly.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_CHANGES_ONLY => 'not-bool',
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

        yield 'GreaterThanOrEqualsCondition.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'GreaterThanOrEqualsCondition.aggregation.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 42,
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

        yield 'GreaterThanOrEqualsCondition.changesOnly.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_CHANGES_ONLY => 'not-bool',
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

        yield 'LessThanCondition.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'LessThanCondition.aggregation.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 42,
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

        yield 'LessThanCondition.changesOnly.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_CHANGES_ONLY => 'not-bool',
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

        yield 'LessThanOrEqualsCondition.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'LessThanOrEqualsCondition.aggregation.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 42,
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

        yield 'LessThanOrEqualsCondition.changesOnly.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => [],
                        ActionTransformerInterface::KEY_CHANGES_ONLY => 'not-bool',
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

        yield 'BetweenCondition.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 'test-aggregation',
                        ActionTransformerInterface::KEY_CHANGES_ONLY => true,
                    ],
                ],
            ]
        );

        yield 'BetweenCondition.aggregation.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                        ActionTransformerInterface::KEY_AGGREGATION => 42,
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

        yield 'BetweenCondition.changesOnly.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                        ActionTransformerInterface::KEY_CHANGES_ONLY => 'not-bool',
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

        yield 'ChangesCondition.and' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_AND => [[], 'test-skipped'],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_AND => [[]],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.and.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_AND => 'not-array',
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

        yield 'ChangesCondition.or' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_OR => [[], 'test-skipped'],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_OR => [[]],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.or.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_OR => 'not-array',
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

        yield 'ChangesCondition.not' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_NOT => [],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_NOT => [],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.not.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_NOT => 'not-array',
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

        yield 'ChangesCondition.equals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.equals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_EQUALS => 'not-array',
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

        yield 'ChangesCondition.greaterThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_GREATER_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_GREATER_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.greaterThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_GREATER_THAN => 'not-array',
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

        yield 'ChangesCondition.greaterThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.greaterThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => 'not-array',
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

        yield 'ChangesCondition.lessThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_LESS_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_LESS_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.lessThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_LESS_THAN => 'not-array',
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

        yield 'ChangesCondition.lessThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.lessThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => 'not-array',
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

        yield 'ChangesCondition.between' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_BETWEEN => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_START => [],
                            ActionTransformerInterface::KEY_END => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_BETWEEN => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_START => [],
                            ActionTransformerInterface::KEY_END => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.between.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_BETWEEN => 'not-array',
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

        yield 'ChangesCondition.operand' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_OPERAND => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_OPERAND => [],
                    ],
                ],
            ]
        );

        yield 'ChangesCondition.operand.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_OPERAND => 'not-array',
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

        yield 'RemainsCondition.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                        ActionTransformerInterface::KEY_LATCHING => true,
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
                        ActionTransformerInterface::KEY_LATCHING => true,
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.latching.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                        ActionTransformerInterface::KEY_LATCHING => 'not-bool',
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

        yield 'RemainsCondition.and' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_AND => [[], 'test-skipped'],
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
                        ActionTransformerInterface::KEY_AND => [[]],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.and.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_AND => 'not-array',
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

        yield 'RemainsCondition.or' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_OR => [[], 'test-skipped'],
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
                        ActionTransformerInterface::KEY_OR => [[]],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.or.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_OR => 'not-array',
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

        yield 'RemainsCondition.not' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_NOT => [],
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
                        ActionTransformerInterface::KEY_NOT => [],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.not.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_NOT => 'not-array',
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

        yield 'RemainsCondition.equals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.equals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_EQUALS => 'not-array',
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

        yield 'RemainsCondition.greaterThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_GREATER_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_GREATER_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.greaterThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_GREATER_THAN => 'not-array',
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

        yield 'RemainsCondition.greaterThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.greaterThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => 'not-array',
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

        yield 'RemainsCondition.lessThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_LESS_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_LESS_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.lessThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_LESS_THAN => 'not-array',
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

        yield 'RemainsCondition.lessThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.lessThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => 'not-array',
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

        yield 'RemainsCondition.between' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_BETWEEN => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_START => [],
                            ActionTransformerInterface::KEY_END => [],
                        ],
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
                        ActionTransformerInterface::KEY_BETWEEN => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_START => [],
                            ActionTransformerInterface::KEY_END => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.between.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_BETWEEN => 'not-array',
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

        yield 'RemainsCondition.operand' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_OPERAND => [],
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
                        ActionTransformerInterface::KEY_OPERAND => [],
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'RemainsCondition.operand.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_OPERAND => 'not-array',
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

        yield 'WasCondition.and' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_AND => [[], 'test-skipped'],
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
                        ActionTransformerInterface::KEY_AND => [[]],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.and.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_AND => 'not-array',
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

        yield 'WasCondition.or' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_OR => [[], 'test-skipped'],
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
                        ActionTransformerInterface::KEY_OR => [[]],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.or.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_OR => 'not-array',
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

        yield 'WasCondition.not' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_NOT => [],
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
                        ActionTransformerInterface::KEY_NOT => [],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.not.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_NOT => 'not-array',
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

        yield 'WasCondition.equals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.equals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_EQUALS => 'not-array',
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

        yield 'WasCondition.greaterThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_GREATER_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_GREATER_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.greaterThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_GREATER_THAN => 'not-array',
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

        yield 'WasCondition.greaterThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.greaterThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => 'not-array',
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

        yield 'WasCondition.lessThan' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_LESS_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_LESS_THAN => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.lessThan.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_LESS_THAN => 'not-array',
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

        yield 'WasCondition.lessThanOrEquals' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
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
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                            ActionTransformerInterface::KEY_LEFT => [],
                            ActionTransformerInterface::KEY_RIGHT => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.lessThanOrEquals.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => 'not-array',
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

        yield 'WasCondition.between' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_BETWEEN => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_START => [],
                            ActionTransformerInterface::KEY_END => [],
                        ],
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
                        ActionTransformerInterface::KEY_BETWEEN => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_START => [],
                            ActionTransformerInterface::KEY_END => [],
                        ],
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ]
        );

        yield 'WasCondition.between.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_BETWEEN => 'not-array',
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

        yield 'WasCondition.operand' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                        ActionTransformerInterface::KEY_OPERAND => [],
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
                        ActionTransformerInterface::KEY_OPERAND => [],
                    ],
                ],
            ]
        );
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
