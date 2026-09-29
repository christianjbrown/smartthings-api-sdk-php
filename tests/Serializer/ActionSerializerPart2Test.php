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
final class ActionSerializerPart2Test extends TestCase
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
        $serializer = new ActionSerializer();

        self::assertSame($expected, $serializer->serialize($factory()));
    }

    /**
     * @return iterable<string, array{Closure(): ActionInterface, array<array-key, mixed>}>
     */
    public static function provideSerializeCases(): iterable
    {
        yield 'SceneComponent.capabilities' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceRequest((new SceneDeviceRequest())
                        ->setComponents([(new SceneComponent())
                            ->setCapabilities([new SceneCapability()])]))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_REQUEST => [
                        ActionSerializerInterface::KEY_COMPONENTS => [[
                            ActionSerializerInterface::KEY_CAPABILITIES => [[]],
                        ]],
                    ],
                ],
            ]
        );

        yield 'SceneCapability.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceGroupRequest((new SceneDeviceGroupRequest('test-device-group-id'))
                        ->setCapability((new SceneCapability())
                            ->setCapabilityId('test-capability-id')
                            ->setStatus('test-status')))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionSerializerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionSerializerInterface::KEY_CAPABILITY => [
                            ActionSerializerInterface::KEY_CAPABILITY_ID => 'test-capability-id',
                            ActionSerializerInterface::KEY_STATUS => 'test-status',
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneCapability.commands' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceGroupRequest((new SceneDeviceGroupRequest('test-device-group-id'))
                        ->setCapability((new SceneCapability())
                            ->setCommands(['test-key' => new SceneCommand()])))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionSerializerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionSerializerInterface::KEY_CAPABILITY => [
                            ActionSerializerInterface::KEY_COMMANDS => ['test-key' => []],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneCommand.arguments' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceGroupRequest((new SceneDeviceGroupRequest('test-device-group-id'))
                        ->setCapability((new SceneCapability())
                            ->setCommands(['test-key' => (new SceneCommand())
                                ->setArguments([new SceneArgument()])])))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionSerializerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionSerializerInterface::KEY_CAPABILITY => [
                            ActionSerializerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionSerializerInterface::KEY_ARGUMENTS => [[]],
                            ]],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneArgument.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceGroupRequest((new SceneDeviceGroupRequest('test-device-group-id'))
                        ->setCapability((new SceneCapability())
                            ->setCommands(['test-key' => (new SceneCommand())
                                ->setArguments([(new SceneArgument())
                                    ->setName('test-name')
                                    ->setSchema(['test-schema-key' => 'test-value'])
                                    ->setValue(['test-value-key' => 'test-value'])])])))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionSerializerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionSerializerInterface::KEY_CAPABILITY => [
                            ActionSerializerInterface::KEY_COMMANDS => ['test-key' => [
                                ActionSerializerInterface::KEY_ARGUMENTS => [[
                                    ActionSerializerInterface::KEY_NAME => 'test-name',
                                    ActionSerializerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                                    ActionSerializerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
                                ]],
                            ]],
                        ],
                    ],
                ],
            ]
        );

        yield 'SceneModeRequest.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setModeRequest((new SceneModeRequest('test-mode-id'))
                        ->setActionId('test-action-id')
                        ->setModeName('test-mode-name'))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_MODE_REQUEST => [
                        ActionSerializerInterface::KEY_MODE_ID => 'test-mode-id',
                        ActionSerializerInterface::KEY_ACTION_ID => 'test-action-id',
                        ActionSerializerInterface::KEY_MODE_NAME => 'test-mode-name',
                    ],
                ],
            ]
        );

        yield 'SceneDeviceGroupRequest.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceGroupRequest((new SceneDeviceGroupRequest('test-device-group-id'))
                        ->setActionId('test-action-id'))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionSerializerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionSerializerInterface::KEY_ACTION_ID => 'test-action-id',
                    ],
                ],
            ]
        );

        yield 'SceneDeviceGroupRequest.capability' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setScene((new SceneAction())
                    ->setDeviceGroupRequest((new SceneDeviceGroupRequest('test-device-group-id'))
                        ->setCapability(new SceneCapability()))),
            [
                ActionSerializerInterface::KEY_SCENE => [
                    ActionSerializerInterface::KEY_DEVICE_GROUP_REQUEST => [
                        ActionSerializerInterface::KEY_DEVICE_GROUP_ID => 'test-device-group-id',
                        ActionSerializerInterface::KEY_CAPABILITY => [],
                    ],
                ],
            ]
        );

        yield 'EveryAction.interval' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setEvery((new EveryAction([new Action()]))
                    ->setInterval(new Interval(new Operand(), 'test-unit'))),
            [
                ActionSerializerInterface::KEY_EVERY => [
                    ActionSerializerInterface::KEY_INTERVAL => [
                        ActionSerializerInterface::KEY_VALUE => [],
                        ActionSerializerInterface::KEY_UNIT => 'test-unit',
                    ],
                    ActionSerializerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'EveryAction.specific' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setEvery((new EveryAction([new Action()]))
                    ->setSpecific(new DateTimeOperand('test-reference'))),
            [
                ActionSerializerInterface::KEY_EVERY => [
                    ActionSerializerInterface::KEY_SPECIFIC => [
                        ActionSerializerInterface::KEY_REFERENCE => 'test-reference',
                    ],
                    ActionSerializerInterface::KEY_ACTIONS => [[]],
                ],
            ]
        );

        yield 'EveryAction.sequence' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setEvery((new EveryAction([new Action()]))
                    ->setSequence(new ActionSequence())),
            [
                ActionSerializerInterface::KEY_EVERY => [
                    ActionSerializerInterface::KEY_ACTIONS => [[]],
                    ActionSerializerInterface::KEY_SEQUENCE => [],
                ],
            ]
        );

        yield 'ActionSequence.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setEvery((new EveryAction([new Action()]))
                    ->setSequence((new ActionSequence())
                        ->setActions('test-actions'))),
            [
                ActionSerializerInterface::KEY_EVERY => [
                    ActionSerializerInterface::KEY_ACTIONS => [[]],
                    ActionSerializerInterface::KEY_SEQUENCE => [
                        ActionSerializerInterface::KEY_ACTIONS => 'test-actions',
                    ],
                ],
            ]
        );

        yield 'LocationAction.scalars' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setLocation((new LocationAction())
                    ->setLocationId('test-location-id')
                    ->setMode('test-mode')),
            [
                ActionSerializerInterface::KEY_LOCATION => [
                    ActionSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                    ActionSerializerInterface::KEY_MODE => 'test-mode',
                ],
            ]
        );

        yield 'LimitAction.sequence' => self::serializeCase(
            static fn (): ActionInterface => (new Action())
                ->setLimit((new LimitAction(7, 'test-period', [new Action()]))
                    ->setSequence(new ActionSequence())),
            [
                ActionSerializerInterface::KEY_LIMIT => [
                    ActionSerializerInterface::KEY_COUNT => 7,
                    ActionSerializerInterface::KEY_PERIOD => 'test-period',
                    ActionSerializerInterface::KEY_ACTIONS => [[]],
                    ActionSerializerInterface::KEY_SEQUENCE => [],
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
