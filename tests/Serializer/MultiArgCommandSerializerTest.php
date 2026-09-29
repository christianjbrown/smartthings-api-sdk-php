<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\MultiArgCommand;
use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItemInterface;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandArgumentsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandSerializer;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MultiArgCommand::class)]
#[CoversClass(MultiArgCommandSerializer::class)]
final class MultiArgCommandSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $multiArgCommandArgumentsItemModel = self::createStub(MultiArgCommandArgumentsItemInterface::class);
        $multiArgCommandArgumentsItemSerializer = self::createStub(MultiArgCommandArgumentsItemSerializerInterface::class);
        $multiArgCommandArgumentsItemSerializer->method('serialize')->willReturn(['test-serialized-multi-arg-command-arguments-item']);
        $model = new MultiArgCommand('test-command', [$multiArgCommandArgumentsItemModel]);

        $serializer = new MultiArgCommandSerializer($multiArgCommandArgumentsItemSerializer);

        self::assertSame(
            [
                MultiArgCommandSerializerInterface::KEY_COMMAND => 'test-command',
                MultiArgCommandSerializerInterface::KEY_ARGUMENTS => [['test-serialized-multi-arg-command-arguments-item']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $multiArgCommandArgumentsItemModel = self::createStub(MultiArgCommandArgumentsItemInterface::class);
        $multiArgCommandArgumentsItemSerializer = self::createStub(MultiArgCommandArgumentsItemSerializerInterface::class);
        $multiArgCommandArgumentsItemSerializer->method('serialize')->willReturn(['test-serialized-multi-arg-command-arguments-item']);
        $model = (new MultiArgCommand('test-command', [$multiArgCommandArgumentsItemModel]))
            ->setSupportedValues('test-supported-values');

        $serializer = new MultiArgCommandSerializer($multiArgCommandArgumentsItemSerializer);

        self::assertSame(
            [
                MultiArgCommandSerializerInterface::KEY_COMMAND => 'test-command',
                MultiArgCommandSerializerInterface::KEY_ARGUMENTS => [['test-serialized-multi-arg-command-arguments-item']],
                MultiArgCommandSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            ],
            $serializer->serialize($model)
        );
    }
}
