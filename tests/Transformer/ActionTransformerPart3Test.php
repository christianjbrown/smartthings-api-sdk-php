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
final class ActionTransformerPart3Test extends TestCase
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
        $transformer = new ActionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, (new ActionSerializer())->serialize($actual));
    }

    /**
     * @return iterable<string, array{array<array-key, mixed>, array<array-key, mixed>}>
     */
    public static function provideTransformCases(): iterable
    {
        yield 'WasCondition.operand.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_WAS => [
                        ActionTransformerInterface::KEY_ID => 'test-id',
                        ActionTransformerInterface::KEY_DURATION => [
                            ActionTransformerInterface::KEY_VALUE => [],
                            ActionTransformerInterface::KEY_UNIT => 'test-unit',
                        ],
                        ActionTransformerInterface::KEY_OPERAND => 'not-array',
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

        yield 'IfActionSequence.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_THEN => 'test-then',
                        ActionTransformerInterface::KEY_ELSE => 'test-else',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_THEN => 'test-then',
                        ActionTransformerInterface::KEY_ELSE => 'test-else',
                    ],
                ],
            ]
        );

        yield 'IfActionSequence.then.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_THEN => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'IfActionSequence.else.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_ELSE => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_IF => [
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'CommandAction.sequence' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ],
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'CommandAction.sequence.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionTransformerInterface::KEY_SEQUENCE => 'not-array',
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

        yield 'RuleDeviceCommand.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                        ActionTransformerInterface::KEY_ARGUMENTS => ['test-arguments-key' => 'test-value'],
                        ActionTransformerInterface::KEY_COMMAND_ID => 'test-command-id',
                    ]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_COMPONENT => 'test-component',
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                        ActionTransformerInterface::KEY_ARGUMENTS => ['test-arguments-key' => 'test-value'],
                        ActionTransformerInterface::KEY_COMMAND_ID => 'test-command-id',
                    ]],
                ],
            ]
        );

        yield 'RuleDeviceCommand.component.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_COMPONENT => 42,
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

        yield 'RuleDeviceCommand.arguments.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                        ActionTransformerInterface::KEY_ARGUMENTS => 'not-array',
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

        yield 'RuleDeviceCommand.commandId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                        ActionTransformerInterface::KEY_COMMAND_ID => 42,
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

        yield 'CommandSequence.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_COMMANDS => 'test-commands',
                        ActionTransformerInterface::KEY_DEVICES => 'test-devices',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_COMMANDS => 'test-commands',
                        ActionTransformerInterface::KEY_DEVICES => 'test-devices',
                    ],
                ],
            ]
        );

        yield 'CommandSequence.commands.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_COMMANDS => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'CommandSequence.devices.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_DEVICES => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_COMMAND => [
                    ActionTransformerInterface::KEY_DEVICES => ['test-devices-1', 'test-devices-2'],
                    ActionTransformerInterface::KEY_COMMANDS => [[
                        ActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
                        ActionTransformerInterface::KEY_COMMAND => 'test-command',
                    ]],
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'SceneAction.deviceRequest' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [],
                ],
            ]
        );

        yield 'SceneAction.deviceRequest.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [],
            ]
        );

        yield 'SceneAction.modeRequest' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 'test-mode-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 'test-mode-id',
                    ],
                ],
            ]
        );

        yield 'SceneAction.modeRequest.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [],
            ]
        );

        yield 'SceneAction.sleepRequest' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_SLEEP_REQUEST => [
                        ActionTransformerInterface::KEY_SECONDS => 7,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_SLEEP_REQUEST => [
                        ActionTransformerInterface::KEY_SECONDS => 7,
                    ],
                ],
            ]
        );

        yield 'SceneAction.sleepRequest.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_SLEEP_REQUEST => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [],
            ]
        );

        yield 'SceneAction.deviceGroupRequest' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                    ],
                ],
            ]
        );

        yield 'SceneAction.deviceGroupRequest.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [],
            ]
        );

        yield 'SceneDeviceRequest.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
                        ActionTransformerInterface::KEY_ACTION_ID => 'test-action-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
                        ActionTransformerInterface::KEY_ACTION_ID => 'test-action-id',
                    ],
                ],
            ]
        );

        yield 'SceneDeviceRequest.deviceId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_ID => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [],
                ],
            ]
        );

        yield 'SceneDeviceRequest.actionId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_ACTION_ID => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [],
                ],
            ]
        );

        yield 'SceneDeviceRequest.components' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[], 'test-skipped'],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[]],
                    ],
                ],
            ]
        );

        yield 'SceneDeviceRequest.components.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => 'not-array',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [],
                ],
            ]
        );

        yield 'SceneComponent.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[
                            ActionTransformerInterface::KEY_COMPONENT_ID => 'test-component-id',
                        ]],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[
                            ActionTransformerInterface::KEY_COMPONENT_ID => 'test-component-id',
                        ]],
                    ],
                ],
            ]
        );

        yield 'SceneComponent.componentId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[
                            ActionTransformerInterface::KEY_COMPONENT_ID => 42,
                        ]],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[]],
                    ],
                ],
            ]
        );

        yield 'SceneComponent.capabilities' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[
                            ActionTransformerInterface::KEY_CAPABILITIES => [[], 'test-skipped'],
                        ]],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[
                            ActionTransformerInterface::KEY_CAPABILITIES => [[]],
                        ]],
                    ],
                ],
            ]
        );

        yield 'SceneComponent.capabilities.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[
                            ActionTransformerInterface::KEY_CAPABILITIES => 'not-array',
                        ]],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_REQUEST => [
                        ActionTransformerInterface::KEY_COMPONENTS => [[]],
                    ],
                ],
            ]
        );

        yield 'SceneCapability.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id',
                            ActionTransformerInterface::KEY_STATUS => 'test-status',
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id',
                            ActionTransformerInterface::KEY_STATUS => 'test-status',
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneCapability.capabilityId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_CAPABILITY_ID => 42,
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [],
                    ],
                ],
            ]
        );

        yield 'SceneCapability.status.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_STATUS => 42,
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [],
                    ],
                ],
            ]
        );

        yield 'SceneCapability.commands' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [], 'test-skipped' => 'not-array'],
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => []],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneCapability.commands.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => 'not-array',
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [],
                    ],
                ],
            ]
        );

        yield 'SceneCommand.arguments' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[], 'test-skipped'],
                            ]],
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[]],
                            ]],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneCommand.arguments.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => 'not-array',
                            ]],
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => []],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneArgument.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[
                                    ActionTransformerInterface::KEY_NAME => 'test-name',
                                    ActionTransformerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                                    ActionTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
                                ]],
                            ]],
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[
                                    ActionTransformerInterface::KEY_NAME => 'test-name',
                                    ActionTransformerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                                    ActionTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
                                ]],
                            ]],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneArgument.name.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[
                                    ActionTransformerInterface::KEY_NAME => 42,
                                ]],
                            ]],
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[]],
                            ]],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneArgument.schema.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[
                                    ActionTransformerInterface::KEY_SCHEMA => 'not-array',
                                ]],
                            ]],
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[]],
                            ]],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneArgument.value.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[
                                    ActionTransformerInterface::KEY_VALUE => 'not-array',
                                ]],
                            ]],
                        ],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [
                            ActionTransformerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionTransformerInterface::KEY_ARGUMENTS => [[]],
                            ]],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneModeRequest.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 'test-mode-id',
                        ActionTransformerInterface::KEY_ACTION_ID => 'test-action-id',
                        ActionTransformerInterface::KEY_MODE_NAME => 'test-mode-name',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 'test-mode-id',
                        ActionTransformerInterface::KEY_ACTION_ID => 'test-action-id',
                        ActionTransformerInterface::KEY_MODE_NAME => 'test-mode-name',
                    ],
                ],
            ]
        );

        yield 'SceneModeRequest.actionId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 'test-mode-id',
                        ActionTransformerInterface::KEY_ACTION_ID => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 'test-mode-id',
                    ],
                ],
            ]
        );

        yield 'SceneModeRequest.modeName.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 'test-mode-id',
                        ActionTransformerInterface::KEY_MODE_NAME => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_MODE_REQUEST => [
                        ActionTransformerInterface::KEY_MODE_ID => 'test-mode-id',
                    ],
                ],
            ]
        );

        yield 'SceneDeviceGroupRequest.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_ACTION_ID => 'test-action-id',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_ACTION_ID => 'test-action-id',
                    ],
                ],
            ]
        );

        yield 'SceneDeviceGroupRequest.actionId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_ACTION_ID => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                    ],
                ],
            ]
        );

        yield 'SceneDeviceGroupRequest.capability' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [],
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => [],
                    ],
                ],
            ]
        );

        yield 'SceneDeviceGroupRequest.capability.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionTransformerInterface::KEY_CAPABILITY => 'not-array',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_SCENE => [
                    ActionTransformerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionTransformerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                    ],
                ],
            ]
        );

        yield 'EveryAction.interval' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_INTERVAL => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_UNIT => 'test-unit',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_INTERVAL => [
                        ActionTransformerInterface::KEY_VALUE => [],
                        ActionTransformerInterface::KEY_UNIT => 'test-unit',
                    ],
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'EveryAction.interval.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_INTERVAL => 'not-array',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'EveryAction.specific' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => [
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

        yield 'EveryAction.specific.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_SPECIFIC => 'not-array',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'EveryAction.sequence' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'EveryAction.sequence.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => 'not-array',
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'ActionSequence.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_ACTIONS => 'test-actions',
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_ACTIONS => 'test-actions',
                    ],
                ],
            ]
        );

        yield 'ActionSequence.actions.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => [
                        ActionTransformerInterface::KEY_ACTIONS => 42,
                    ],
                ],
            ],
            [
                ActionTransformerInterface::KEY_EVERY => [
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'LocationAction.scalars' => self::transformCase(
            [
                ActionTransformerInterface::KEY_LOCATION => [
                    ActionTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
                    ActionTransformerInterface::KEY_MODE => 'test-mode',
                ],
            ],
            [
                ActionTransformerInterface::KEY_LOCATION => [
                    ActionTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
                    ActionTransformerInterface::KEY_MODE => 'test-mode',
                ],
            ]
        );

        yield 'LocationAction.locationId.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_LOCATION => [
                    ActionTransformerInterface::KEY_LOCATION_ID => 42,
                ],
            ],
            [
                ActionTransformerInterface::KEY_LOCATION => [],
            ]
        );

        yield 'LocationAction.mode.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_LOCATION => [
                    ActionTransformerInterface::KEY_MODE => 42,
                ],
            ],
            [
                ActionTransformerInterface::KEY_LOCATION => [],
            ]
        );

        yield 'LimitAction.sequence' => self::transformCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ],
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'LimitAction.sequence.wrongType' => self::transformCase(
            [
                ActionTransformerInterface::KEY_LIMIT => [
                    ActionTransformerInterface::KEY_COUNT => 7,
                    ActionTransformerInterface::KEY_PERIOD => 'test-period',
                    ActionTransformerInterface::KEY_ACTIONS => [[]],
                    ActionTransformerInterface::KEY_SEQUENCE => 'not-array',
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
