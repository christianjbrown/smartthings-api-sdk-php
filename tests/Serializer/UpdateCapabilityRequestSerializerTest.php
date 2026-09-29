<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AttributeDataSchema;
use ChristianBrown\SmartThings\Model\AttributeProperties;
use ChristianBrown\SmartThings\Model\AttributeSchema;
use ChristianBrown\SmartThings\Model\AttributeUnitSchema;
use ChristianBrown\SmartThings\Model\AttributeValueSchema;
use ChristianBrown\SmartThings\Model\CapabilityAttribute;
use ChristianBrown\SmartThings\Model\CapabilityCommand;
use ChristianBrown\SmartThings\Model\CommandArgument;
use ChristianBrown\SmartThings\Model\EnumCommand;
use ChristianBrown\SmartThings\Model\UpdateCapabilityRequest;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeDataSchema::class)]
#[CoversClass(AttributeProperties::class)]
#[CoversClass(AttributeSchema::class)]
#[CoversClass(AttributeUnitSchema::class)]
#[CoversClass(AttributeValueSchema::class)]
#[CoversClass(CapabilityAttribute::class)]
#[CoversClass(CapabilityCommand::class)]
#[CoversClass(CommandArgument::class)]
#[CoversClass(EnumCommand::class)]
#[CoversClass(UpdateCapabilityRequest::class)]
#[CoversClass(UpdateCapabilityRequestSerializer::class)]
final class UpdateCapabilityRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new UpdateCapabilityRequest();

        $serializer = new UpdateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new UpdateCapabilityRequest())
            ->setAttributes(['test-key' => (new CapabilityAttribute())
                ->setSchema((new AttributeSchema((new AttributeProperties((new AttributeValueSchema())
                    ->setType('test-type')
                    ->setEnum(['test-enum-1', 'test-enum-2'])
                    ->setAdditionalKeywords(['test-additional-keywords-key' => 'test-value'])))
                    ->setUnit((new AttributeUnitSchema())
                        ->setType('test-type')
                        ->setEnum(['test-enum-1', 'test-enum-2'])
                        ->setDefault('test-default'))
                    ->setData((new AttributeDataSchema('test-type'))
                        ->setAdditionalProperties(true)
                        ->setRequired(['test-required-1', 'test-required-2'])
                        ->setProperties(['test-properties-key' => 'test-value']))))
                    ->setTitle('test-title')
                    ->setType('test-type')
                    ->setSensitive(true)
                    ->setAdditionalProperties(true)
                    ->setRequired(['test-required-1', 'test-required-2']))
                ->setSetter('test-setter')
                ->setEnumCommands([new EnumCommand('test-command', 'test-value')])])
            ->setCommands(['test-key' => (new CapabilityCommand('test-name'))
                ->setArguments([(new CommandArgument('test-name', ['test-schema-key' => 'test-value']))
                    ->setOptional(true)])
                ->setSensitive(true)]);

        $serializer = new UpdateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    UpdateCapabilityRequestSerializerInterface::KEY_SCHEMA => [
                        UpdateCapabilityRequestSerializerInterface::KEY_TITLE => 'test-title',
                        UpdateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                        UpdateCapabilityRequestSerializerInterface::KEY_PROPERTIES => [
                            UpdateCapabilityRequestSerializerInterface::KEY_VALUE => [
                                UpdateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                                UpdateCapabilityRequestSerializerInterface::KEY_ENUM => ['test-enum-1', 'test-enum-2'],
                                'test-additional-keywords-key' => 'test-value',
                            ],
                            UpdateCapabilityRequestSerializerInterface::KEY_UNIT => [
                                UpdateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                                UpdateCapabilityRequestSerializerInterface::KEY_ENUM => ['test-enum-1', 'test-enum-2'],
                                UpdateCapabilityRequestSerializerInterface::KEY_DEFAULT => 'test-default',
                            ],
                            UpdateCapabilityRequestSerializerInterface::KEY_DATA => [
                                UpdateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                                UpdateCapabilityRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => true,
                                UpdateCapabilityRequestSerializerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
                                UpdateCapabilityRequestSerializerInterface::KEY_PROPERTIES => ['test-properties-key' => 'test-value'],
                            ],
                        ],
                        UpdateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                        UpdateCapabilityRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => true,
                        UpdateCapabilityRequestSerializerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
                    ],
                    UpdateCapabilityRequestSerializerInterface::KEY_SETTER => 'test-setter',
                    UpdateCapabilityRequestSerializerInterface::KEY_ENUM_COMMANDS => [[
                        UpdateCapabilityRequestSerializerInterface::KEY_COMMAND => 'test-command',
                        UpdateCapabilityRequestSerializerInterface::KEY_VALUE => 'test-value',
                    ]],
                ]],
                UpdateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    UpdateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                    UpdateCapabilityRequestSerializerInterface::KEY_ARGUMENTS => [[
                        UpdateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                        UpdateCapabilityRequestSerializerInterface::KEY_OPTIONAL => true,
                        UpdateCapabilityRequestSerializerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                    ]],
                    UpdateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth1(): void
    {
        $request = (new UpdateCapabilityRequest())
            ->setAttributes(['test-key' => new CapabilityAttribute()])
            ->setCommands(['test-key' => new CapabilityCommand('test-name')]);

        $serializer = new UpdateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => []],
                UpdateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    UpdateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth2(): void
    {
        $request = (new UpdateCapabilityRequest())
            ->setAttributes(['test-key' => (new CapabilityAttribute())
                ->setSchema(new AttributeSchema(new AttributeProperties(new AttributeValueSchema())))
                ->setSetter('test-setter')
                ->setEnumCommands([new EnumCommand('test-command', 'test-value')])])
            ->setCommands(['test-key' => (new CapabilityCommand('test-name'))
                ->setArguments([new CommandArgument('test-name', ['test-schema-key' => 'test-value'])])
                ->setSensitive(true)]);

        $serializer = new UpdateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    UpdateCapabilityRequestSerializerInterface::KEY_SCHEMA => [
                        UpdateCapabilityRequestSerializerInterface::KEY_PROPERTIES => [
                            UpdateCapabilityRequestSerializerInterface::KEY_VALUE => [],
                        ],
                    ],
                    UpdateCapabilityRequestSerializerInterface::KEY_SETTER => 'test-setter',
                    UpdateCapabilityRequestSerializerInterface::KEY_ENUM_COMMANDS => [[
                        UpdateCapabilityRequestSerializerInterface::KEY_COMMAND => 'test-command',
                        UpdateCapabilityRequestSerializerInterface::KEY_VALUE => 'test-value',
                    ]],
                ]],
                UpdateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    UpdateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                    UpdateCapabilityRequestSerializerInterface::KEY_ARGUMENTS => [[
                        UpdateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                        UpdateCapabilityRequestSerializerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                    ]],
                    UpdateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth3(): void
    {
        $request = (new UpdateCapabilityRequest())
            ->setAttributes(['test-key' => (new CapabilityAttribute())
                ->setSchema((new AttributeSchema(new AttributeProperties(new AttributeValueSchema())))
                    ->setTitle('test-title')
                    ->setType('test-type')
                    ->setSensitive(true)
                    ->setAdditionalProperties(true)
                    ->setRequired(['test-required-1', 'test-required-2']))
                ->setSetter('test-setter')
                ->setEnumCommands([new EnumCommand('test-command', 'test-value')])])
            ->setCommands(['test-key' => (new CapabilityCommand('test-name'))
                ->setArguments([(new CommandArgument('test-name', ['test-schema-key' => 'test-value']))
                    ->setOptional(true)])
                ->setSensitive(true)]);

        $serializer = new UpdateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    UpdateCapabilityRequestSerializerInterface::KEY_SCHEMA => [
                        UpdateCapabilityRequestSerializerInterface::KEY_TITLE => 'test-title',
                        UpdateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                        UpdateCapabilityRequestSerializerInterface::KEY_PROPERTIES => [
                            UpdateCapabilityRequestSerializerInterface::KEY_VALUE => [],
                        ],
                        UpdateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                        UpdateCapabilityRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => true,
                        UpdateCapabilityRequestSerializerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
                    ],
                    UpdateCapabilityRequestSerializerInterface::KEY_SETTER => 'test-setter',
                    UpdateCapabilityRequestSerializerInterface::KEY_ENUM_COMMANDS => [[
                        UpdateCapabilityRequestSerializerInterface::KEY_COMMAND => 'test-command',
                        UpdateCapabilityRequestSerializerInterface::KEY_VALUE => 'test-value',
                    ]],
                ]],
                UpdateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    UpdateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                    UpdateCapabilityRequestSerializerInterface::KEY_ARGUMENTS => [[
                        UpdateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                        UpdateCapabilityRequestSerializerInterface::KEY_OPTIONAL => true,
                        UpdateCapabilityRequestSerializerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                    ]],
                    UpdateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth4(): void
    {
        $request = (new UpdateCapabilityRequest())
            ->setAttributes(['test-key' => (new CapabilityAttribute())
                ->setSchema((new AttributeSchema((new AttributeProperties(new AttributeValueSchema()))
                    ->setUnit(new AttributeUnitSchema())
                    ->setData(new AttributeDataSchema('test-type'))))
                    ->setTitle('test-title')
                    ->setType('test-type')
                    ->setSensitive(true)
                    ->setAdditionalProperties(true)
                    ->setRequired(['test-required-1', 'test-required-2']))
                ->setSetter('test-setter')
                ->setEnumCommands([new EnumCommand('test-command', 'test-value')])])
            ->setCommands(['test-key' => (new CapabilityCommand('test-name'))
                ->setArguments([(new CommandArgument('test-name', ['test-schema-key' => 'test-value']))
                    ->setOptional(true)])
                ->setSensitive(true)]);

        $serializer = new UpdateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    UpdateCapabilityRequestSerializerInterface::KEY_SCHEMA => [
                        UpdateCapabilityRequestSerializerInterface::KEY_TITLE => 'test-title',
                        UpdateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                        UpdateCapabilityRequestSerializerInterface::KEY_PROPERTIES => [
                            UpdateCapabilityRequestSerializerInterface::KEY_VALUE => [],
                            UpdateCapabilityRequestSerializerInterface::KEY_UNIT => [],
                            UpdateCapabilityRequestSerializerInterface::KEY_DATA => [
                                UpdateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                            ],
                        ],
                        UpdateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                        UpdateCapabilityRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => true,
                        UpdateCapabilityRequestSerializerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
                    ],
                    UpdateCapabilityRequestSerializerInterface::KEY_SETTER => 'test-setter',
                    UpdateCapabilityRequestSerializerInterface::KEY_ENUM_COMMANDS => [[
                        UpdateCapabilityRequestSerializerInterface::KEY_COMMAND => 'test-command',
                        UpdateCapabilityRequestSerializerInterface::KEY_VALUE => 'test-value',
                    ]],
                ]],
                UpdateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    UpdateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                    UpdateCapabilityRequestSerializerInterface::KEY_ARGUMENTS => [[
                        UpdateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                        UpdateCapabilityRequestSerializerInterface::KEY_OPTIONAL => true,
                        UpdateCapabilityRequestSerializerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                    ]],
                    UpdateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                ]],
            ],
            $actual
        );
    }
}
