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
use ChristianBrown\SmartThings\Model\CreateCapabilityRequest;
use ChristianBrown\SmartThings\Model\EnumCommand;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityRequestSerializerInterface;
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
#[CoversClass(CreateCapabilityRequest::class)]
#[CoversClass(EnumCommand::class)]
#[CoversClass(CreateCapabilityRequestSerializer::class)]
final class CreateCapabilityRequestSerializerTest extends TestCase
{
    public function testSerializeAttributeWithoutNestedSchemaParts(): void
    {
        $request = (new CreateCapabilityRequest('test-name'))
            ->setAttributes([
                'test-no-properties' => (new CapabilityAttribute())->setSchema(new AttributeSchema(null)),
                'test-no-value' => (new CapabilityAttribute())->setSchema(new AttributeSchema(new AttributeProperties(null))),
            ]);

        $serializer = new CreateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                CreateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => [
                    'test-no-properties' => [CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => []],
                    'test-no-value' => [CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => [CreateCapabilityRequestSerializerInterface::KEY_PROPERTIES => []]],
                ],
            ],
            $actual
        );
    }

    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new CreateCapabilityRequest('test-name');

        $serializer = new CreateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new CreateCapabilityRequest('test-name'))
            ->setEphemeral(true)
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

        $serializer = new CreateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                CreateCapabilityRequestSerializerInterface::KEY_EPHEMERAL => true,
                CreateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => [
                        CreateCapabilityRequestSerializerInterface::KEY_TITLE => 'test-title',
                        CreateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                        CreateCapabilityRequestSerializerInterface::KEY_PROPERTIES => [
                            CreateCapabilityRequestSerializerInterface::KEY_VALUE => [
                                CreateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                                CreateCapabilityRequestSerializerInterface::KEY_ENUM => ['test-enum-1', 'test-enum-2'],
                                'test-additional-keywords-key' => 'test-value',
                            ],
                            CreateCapabilityRequestSerializerInterface::KEY_UNIT => [
                                CreateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                                CreateCapabilityRequestSerializerInterface::KEY_ENUM => ['test-enum-1', 'test-enum-2'],
                                CreateCapabilityRequestSerializerInterface::KEY_DEFAULT => 'test-default',
                            ],
                            CreateCapabilityRequestSerializerInterface::KEY_DATA => [
                                CreateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                                CreateCapabilityRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => true,
                                CreateCapabilityRequestSerializerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
                                CreateCapabilityRequestSerializerInterface::KEY_PROPERTIES => ['test-properties-key' => 'test-value'],
                            ],
                        ],
                        CreateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                        CreateCapabilityRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => true,
                        CreateCapabilityRequestSerializerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
                    ],
                    CreateCapabilityRequestSerializerInterface::KEY_SETTER => 'test-setter',
                    CreateCapabilityRequestSerializerInterface::KEY_ENUM_COMMANDS => [[
                        CreateCapabilityRequestSerializerInterface::KEY_COMMAND => 'test-command',
                        CreateCapabilityRequestSerializerInterface::KEY_VALUE => 'test-value',
                    ]],
                ]],
                CreateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                    CreateCapabilityRequestSerializerInterface::KEY_ARGUMENTS => [[
                        CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                        CreateCapabilityRequestSerializerInterface::KEY_OPTIONAL => true,
                        CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                    ]],
                    CreateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth1(): void
    {
        $request = (new CreateCapabilityRequest('test-name'))
            ->setEphemeral(true)
            ->setAttributes(['test-key' => new CapabilityAttribute()])
            ->setCommands(['test-key' => new CapabilityCommand('test-name')]);

        $serializer = new CreateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                CreateCapabilityRequestSerializerInterface::KEY_EPHEMERAL => true,
                CreateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => []],
                CreateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth2(): void
    {
        $request = (new CreateCapabilityRequest('test-name'))
            ->setEphemeral(true)
            ->setAttributes(['test-key' => (new CapabilityAttribute())
                ->setSchema(new AttributeSchema(new AttributeProperties(new AttributeValueSchema())))
                ->setSetter('test-setter')
                ->setEnumCommands([new EnumCommand('test-command', 'test-value')])])
            ->setCommands(['test-key' => (new CapabilityCommand('test-name'))
                ->setArguments([new CommandArgument('test-name', ['test-schema-key' => 'test-value'])])
                ->setSensitive(true)]);

        $serializer = new CreateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                CreateCapabilityRequestSerializerInterface::KEY_EPHEMERAL => true,
                CreateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => [
                        CreateCapabilityRequestSerializerInterface::KEY_PROPERTIES => [
                            CreateCapabilityRequestSerializerInterface::KEY_VALUE => [],
                        ],
                    ],
                    CreateCapabilityRequestSerializerInterface::KEY_SETTER => 'test-setter',
                    CreateCapabilityRequestSerializerInterface::KEY_ENUM_COMMANDS => [[
                        CreateCapabilityRequestSerializerInterface::KEY_COMMAND => 'test-command',
                        CreateCapabilityRequestSerializerInterface::KEY_VALUE => 'test-value',
                    ]],
                ]],
                CreateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                    CreateCapabilityRequestSerializerInterface::KEY_ARGUMENTS => [[
                        CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                        CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                    ]],
                    CreateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth3(): void
    {
        $request = (new CreateCapabilityRequest('test-name'))
            ->setEphemeral(true)
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

        $serializer = new CreateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                CreateCapabilityRequestSerializerInterface::KEY_EPHEMERAL => true,
                CreateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => [
                        CreateCapabilityRequestSerializerInterface::KEY_TITLE => 'test-title',
                        CreateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                        CreateCapabilityRequestSerializerInterface::KEY_PROPERTIES => [
                            CreateCapabilityRequestSerializerInterface::KEY_VALUE => [],
                        ],
                        CreateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                        CreateCapabilityRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => true,
                        CreateCapabilityRequestSerializerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
                    ],
                    CreateCapabilityRequestSerializerInterface::KEY_SETTER => 'test-setter',
                    CreateCapabilityRequestSerializerInterface::KEY_ENUM_COMMANDS => [[
                        CreateCapabilityRequestSerializerInterface::KEY_COMMAND => 'test-command',
                        CreateCapabilityRequestSerializerInterface::KEY_VALUE => 'test-value',
                    ]],
                ]],
                CreateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                    CreateCapabilityRequestSerializerInterface::KEY_ARGUMENTS => [[
                        CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                        CreateCapabilityRequestSerializerInterface::KEY_OPTIONAL => true,
                        CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                    ]],
                    CreateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth4(): void
    {
        $request = (new CreateCapabilityRequest('test-name'))
            ->setEphemeral(true)
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

        $serializer = new CreateCapabilityRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                CreateCapabilityRequestSerializerInterface::KEY_EPHEMERAL => true,
                CreateCapabilityRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => [
                        CreateCapabilityRequestSerializerInterface::KEY_TITLE => 'test-title',
                        CreateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                        CreateCapabilityRequestSerializerInterface::KEY_PROPERTIES => [
                            CreateCapabilityRequestSerializerInterface::KEY_VALUE => [],
                            CreateCapabilityRequestSerializerInterface::KEY_UNIT => [],
                            CreateCapabilityRequestSerializerInterface::KEY_DATA => [
                                CreateCapabilityRequestSerializerInterface::KEY_TYPE => 'test-type',
                            ],
                        ],
                        CreateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                        CreateCapabilityRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => true,
                        CreateCapabilityRequestSerializerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
                    ],
                    CreateCapabilityRequestSerializerInterface::KEY_SETTER => 'test-setter',
                    CreateCapabilityRequestSerializerInterface::KEY_ENUM_COMMANDS => [[
                        CreateCapabilityRequestSerializerInterface::KEY_COMMAND => 'test-command',
                        CreateCapabilityRequestSerializerInterface::KEY_VALUE => 'test-value',
                    ]],
                ]],
                CreateCapabilityRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                    CreateCapabilityRequestSerializerInterface::KEY_ARGUMENTS => [[
                        CreateCapabilityRequestSerializerInterface::KEY_NAME => 'test-name',
                        CreateCapabilityRequestSerializerInterface::KEY_OPTIONAL => true,
                        CreateCapabilityRequestSerializerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
                    ]],
                    CreateCapabilityRequestSerializerInterface::KEY_SENSITIVE => true,
                ]],
            ],
            $actual
        );
    }
}
