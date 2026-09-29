<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CommandMappingInterface;
use ChristianBrown\SmartThings\Model\CommandMappings;
use ChristianBrown\SmartThings\Transformer\CommandMappingsTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CommandMappingTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommandMappings::class)]
#[CoversClass(CommandMappingsTransformer::class)]
final class CommandMappingsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $commandMappingModel = self::createStub(CommandMappingInterface::class);
        $commandMappingTransformer = self::createStub(CommandMappingTransformerInterface::class);
        $commandMappingTransformer->method('transform')->willReturn($commandMappingModel);
        $data = [
            CommandMappingsTransformerInterface::KEY_COMMANDS => [['test-nested']],
        ];

        $transformer = new CommandMappingsTransformer($commandMappingTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$commandMappingModel], $actual->getCommands());
    }

    public function testTransformCommands(): void
    {
        $commandMappingModel = self::createStub(CommandMappingInterface::class);
        $commandMappingTransformer = self::createStub(CommandMappingTransformerInterface::class);
        $commandMappingTransformer->method('transform')->willReturn($commandMappingModel);
        $transformer = new CommandMappingsTransformer($commandMappingTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getCommands());
        self::assertNull($transformer->transform($base + [CommandMappingsTransformerInterface::KEY_COMMANDS => 'test-not-array'])->getCommands());
        self::assertSame([$commandMappingModel], $transformer->transform($base + [CommandMappingsTransformerInterface::KEY_COMMANDS => [['test-nested'], 'test-skipped']])->getCommands());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $commandMappingModel = self::createStub(CommandMappingInterface::class);
        $commandMappingTransformer = self::createStub(CommandMappingTransformerInterface::class);
        $commandMappingTransformer->method('transform')->willReturn($commandMappingModel);
        $transformer = new CommandMappingsTransformer($commandMappingTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getCommands());
    }
}
