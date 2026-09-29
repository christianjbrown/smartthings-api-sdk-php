<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
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

use function sprintf;

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
final class ActionTransformerUnexpectedTest extends TestCase
{
    /**
     * @param array<array-key, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ActionTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<array-key, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'EqualsCondition.left.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'EqualsCondition.left.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'EqualsCondition.right.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'EqualsCondition.right.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'ArrayOperand.operands.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_ARRAY => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_OPERANDS)
        );

        yield 'ArrayOperand.operands.wrongReq' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_OPERANDS)
        );

        yield 'DeviceOperand.devices.missing' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DEVICES)
        );

        yield 'DeviceOperand.devices.wrongReq' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DEVICES)
        );

        yield 'DeviceOperand.component.missing' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_COMPONENT)
        );

        yield 'DeviceOperand.component.wrongReq' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_COMPONENT)
        );

        yield 'DeviceOperand.capability.missing' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_CAPABILITY)
        );

        yield 'DeviceOperand.capability.wrongReq' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_CAPABILITY)
        );

        yield 'DeviceOperand.attribute.missing' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ATTRIBUTE)
        );

        yield 'DeviceOperand.attribute.wrongReq' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ATTRIBUTE)
        );

        yield 'LocationOperand.attribute.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_LOCATION => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ATTRIBUTE)
        );

        yield 'LocationOperand.attribute.wrongReq' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ATTRIBUTE)
        );

        yield 'TimeOperand.reference.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [
                            ActionTransformerInterface::KEY_TIME => [],
                        ],
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_REFERENCE)
        );

        yield 'TimeOperand.reference.wrongReq' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_REFERENCE)
        );

        yield 'Interval.value.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_UNIT => 'test-unit',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_VALUE)
        );

        yield 'Interval.value.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_VALUE => 'not-array',
                        ActionTransformerInterface::KEY_UNIT => 'test-unit',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_VALUE)
        );

        yield 'Interval.unit.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_VALUE => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_UNIT)
        );

        yield 'Interval.unit.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_UNIT => 42,
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_UNIT)
        );

        yield 'DateTimeOperand.reference.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_REFERENCE)
        );

        yield 'DateTimeOperand.reference.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
                        ActionTransformerInterface::KEY_REFERENCE => 42,
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_REFERENCE)
        );

        yield 'GreaterThanCondition.left.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'GreaterThanCondition.left.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'GreaterThanCondition.right.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'GreaterThanCondition.right.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'GreaterThanOrEqualsCondition.left.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'GreaterThanOrEqualsCondition.left.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'GreaterThanOrEqualsCondition.right.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'GreaterThanOrEqualsCondition.right.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_GREATER_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'LessThanCondition.left.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'LessThanCondition.left.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'LessThanCondition.right.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'LessThanCondition.right.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'LessThanOrEqualsCondition.left.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'LessThanOrEqualsCondition.left.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => 'not-array',
                        ActionTransformerInterface::KEY_RIGHT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_LEFT)
        );

        yield 'LessThanOrEqualsCondition.right.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'LessThanOrEqualsCondition.right.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_LESS_THAN_OR_EQUALS => [
                        ActionTransformerInterface::KEY_LEFT => [],
                        ActionTransformerInterface::KEY_RIGHT => 'not-array',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_RIGHT)
        );

        yield 'BetweenCondition.value.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_VALUE)
        );

        yield 'BetweenCondition.value.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => 'not-array',
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_VALUE)
        );

        yield 'BetweenCondition.start.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_START)
        );

        yield 'BetweenCondition.start.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => 'not-array',
                        ActionTransformerInterface::KEY_END => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_START)
        );

        yield 'BetweenCondition.end.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_END)
        );

        yield 'BetweenCondition.end.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_BETWEEN => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_START => [],
                        ActionTransformerInterface::KEY_END => 'not-array',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_END)
        );

        yield 'ChangesCondition.id.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ID)
        );

        yield 'ChangesCondition.id.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_CHANGES => [
                        ActionTransformerInterface::KEY_ID => 42,
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ID)
        );

        yield 'RemainsCondition.id.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ID)
        );

        yield 'RemainsCondition.id.wrongReq' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ID)
        );

        yield 'RemainsCondition.duration.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DURATION)
        );

        yield 'RemainsCondition.duration.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_REMAINS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => 'not-array',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DURATION)
        );

        yield 'WasCondition.id.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ID)
        );

        yield 'WasCondition.id.wrongReq' => self::unexpectedCase(
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
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ID)
        );

        yield 'WasCondition.duration.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DURATION)
        );

        yield 'WasCondition.duration.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => 'not-array',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DURATION)
        );

        yield 'SleepAction.duration.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DURATION)
        );

        yield 'SleepAction.duration.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SLEEP => [
                    ActionTransformerInterface::KEY_DURATION => 'not-array',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DURATION)
        );

        yield 'CommandAction.devices.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DEVICES)
        );

        yield 'CommandAction.devices.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => 'not-array',
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DEVICES)
        );

        yield 'CommandAction.commands.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_COMMANDS)
        );

        yield 'CommandAction.commands.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => 'not-array',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_COMMANDS)
        );

        yield 'RuleDeviceCommand.capability.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_CAPABILITY)
        );

        yield 'RuleDeviceCommand.capability.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 42,
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_CAPABILITY)
        );

        yield 'RuleDeviceCommand.command.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_COMMAND)
        );

        yield 'RuleDeviceCommand.command.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 42,
                    ]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_COMMAND)
        );

        yield 'SceneModeRequest.modeId.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_MODE_ID)
        );

        yield 'SceneModeRequest.modeId.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 42,
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_MODE_ID)
        );

        yield 'SceneSleepRequest.seconds.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_SLEEP_REQUEST => [],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_INT_SPRINTF, ActionTransformerInterface::KEY_SECONDS)
        );

        yield 'SceneSleepRequest.seconds.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_SLEEP_REQUEST => [
                        ActionTransformerInterface::KEY_SECONDS => 'not-int',
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_INT_SPRINTF, ActionTransformerInterface::KEY_SECONDS)
        );

        yield 'SceneDeviceGroupRequest.deviceGroupId.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_DEVICE_GROUP_ID)
        );

        yield 'SceneDeviceGroupRequest.deviceGroupId.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 42,
                    ],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_DEVICE_GROUP_ID)
        );

        yield 'EveryAction.actions.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_EVERY => [],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_ACTIONS)
        );

        yield 'EveryAction.actions.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => 'not-array',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_ACTIONS)
        );

        yield 'LimitAction.count.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_INT_SPRINTF, ActionTransformerInterface::KEY_COUNT)
        );

        yield 'LimitAction.count.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 'not-int',
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_INT_SPRINTF, ActionTransformerInterface::KEY_COUNT)
        );

        yield 'LimitAction.period.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_PERIOD)
        );

        yield 'LimitAction.period.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 42,
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_PERIOD)
        );

        yield 'LimitAction.actions.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_ACTIONS)
        );

        yield 'LimitAction.actions.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => 'not-array',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_ACTIONS)
        );

        yield 'ToggleAction.devices.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DEVICES)
        );

        yield 'ToggleAction.devices.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => 'not-array',
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ActionTransformerInterface::KEY_DEVICES)
        );

        yield 'ToggleAction.component.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_COMPONENT)
        );

        yield 'ToggleAction.component.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 42,
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_COMPONENT)
        );

        yield 'ToggleAction.capability.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_CAPABILITY)
        );

        yield 'ToggleAction.capability.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 42,
                    ActionTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_CAPABILITY)
        );

        yield 'ToggleAction.attribute.missing' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ATTRIBUTE)
        );

        yield 'ToggleAction.attribute.wrongReq' => self::unexpectedCase(
            [
                ActionTransformerInterface::KEY_TOGGLE => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                    ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                    ActionTransformerInterface::KEY_ATTRIBUTE => 42,
                ],
            ],
            sprintf(ActionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionTransformerInterface::KEY_ATTRIBUTE)
        );
    }

    /**
     * @param array<array-key, mixed> $data
     *
     * @return array{array<array-key, mixed>, string}
     */
    private static function unexpectedCase(array $data, string $message): array
    {
        return [$data, $message];
    }
}
