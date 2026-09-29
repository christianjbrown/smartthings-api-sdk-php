<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AttributeValueInterface;
use ChristianBrown\SmartThings\Model\CommandMapping;
use ChristianBrown\SmartThings\Transformer\AttributeValueTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CommandMappingTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new CommandMappingTransformer(self::createStub(AttributeValueTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilityIdAbsent' => [[CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested']], sprintf(CommandMappingTransformerInterface::UNEXPECTED_STRING_SPRINTF, CommandMappingTransformerInterface::KEY_CAPABILITY_ID)];
        yield 'capabilityIdWrongType' => [[CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested'], CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 42], sprintf(CommandMappingTransformerInterface::UNEXPECTED_STRING_SPRINTF, CommandMappingTransformerInterface::KEY_CAPABILITY_ID)];
        yield 'versionAbsent' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested']], sprintf(CommandMappingTransformerInterface::UNEXPECTED_INT_SPRINTF, CommandMappingTransformerInterface::KEY_VERSION)];
        yield 'versionWrongType' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested'], CommandMappingTransformerInterface::KEY_VERSION => 'not-int'], sprintf(CommandMappingTransformerInterface::UNEXPECTED_INT_SPRINTF, CommandMappingTransformerInterface::KEY_VERSION)];
        yield 'commandAbsent' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested']], sprintf(CommandMappingTransformerInterface::UNEXPECTED_STRING_SPRINTF, CommandMappingTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_EVENT_VALUES => ['test-nested'], CommandMappingTransformerInterface::KEY_COMMAND => 42], sprintf(CommandMappingTransformerInterface::UNEXPECTED_STRING_SPRINTF, CommandMappingTransformerInterface::KEY_COMMAND)];
        yield 'eventValuesAbsent' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_COMMAND => 'test-command'], sprintf(CommandMappingTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CommandMappingTransformerInterface::KEY_EVENT_VALUES)];
        yield 'eventValuesWrongType' => [[CommandMappingTransformerInterface::KEY_CAPABILITY_ID => 'test-capability-id', CommandMappingTransformerInterface::KEY_VERSION => 7, CommandMappingTransformerInterface::KEY_COMMAND => 'test-command', CommandMappingTransformerInterface::KEY_EVENT_VALUES => 'not-array'], sprintf(CommandMappingTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CommandMappingTransformerInterface::KEY_EVENT_VALUES)];
    }
}
