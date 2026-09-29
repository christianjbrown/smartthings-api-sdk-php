<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListForArgument;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\ListForArgumentSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ListForArgument::class)]
#[CoversClass(ListForArgumentSerializer::class)]
final class ListForArgumentSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new ListForArgument([$alternativeItemModel], 'test-name');

        $serializer = new ListForArgumentSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListForArgumentSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                ListForArgumentSerializerInterface::KEY_NAME => 'test-name',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new ListForArgument([$alternativeItemModel], 'test-name'))
            ->setSupportedValues('test-supported-values')
            ->setArgumentType('test-argument-type');

        $serializer = new ListForArgumentSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListForArgumentSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                ListForArgumentSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                ListForArgumentSerializerInterface::KEY_NAME => 'test-name',
                ListForArgumentSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ],
            $serializer->serialize($model)
        );
    }
}
