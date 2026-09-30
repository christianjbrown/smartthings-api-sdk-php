<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AttributeValueInterface;
use ChristianBrown\SmartThings\Model\CommandMapping;
use ChristianBrown\SmartThings\Transformer\AttributeValueTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CommandMappingTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommandMapping::class)]
#[CoversClass(CommandMappingTransformer::class)]
final class CommandMappingTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $attributeValueModel = self::createStub(AttributeValueInterface::class);
        $attributeValueTransformer = self::createStub(AttributeValueTransformerInterface::class);
        $attributeValueTransformer->method('transform')->willReturn($attributeValueModel);
        $data = [
            CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id',
            CommandMappingTransformerInterface::KEY_VERSION => 7,
            CommandMappingTransformerInterface::KEY_COMMAND => 'test-command',
            CommandMappingTransformerInterface::KEY_EVENT_VALUES => [['test-nested']],
        ];

        $transformer = new CommandMappingTransformer($attributeValueTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-capability-id', $actual->getCapabilityId());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-command', $actual->getCommand());
        self::assertSame([$attributeValueModel], $actual->getEventValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new CommandMappingTransformer(self::createStub(AttributeValueTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'capabilityIdAbsent' => [[CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested']], 'getCapabilityId', null];
        yield 'capabilityIdWrongType' => [[CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested'], CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 42], 'getCapabilityId', null];
        yield 'versionAbsent' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested']], 'getVersion', null];
        yield 'versionWrongType' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested'], CommandMappingTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'commandAbsent' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested']], 'getCommand', null];
        yield 'commandWrongType' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested'], CommandMappingTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
        yield 'eventValuesAbsent' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_COMMAND => 'test-command'], 'getEventValues', []];
        yield 'eventValuesWrongType' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => 'not-array'], 'getEventValues', []];
    }
}
