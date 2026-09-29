<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeCommand;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeCommandSerializer;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ListWithAvailableSizeCommand::class)]
#[CoversClass(ListWithAvailableSizeCommandSerializer::class)]
final class ListWithAvailableSizeCommandSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new ListWithAvailableSizeCommand([$alternativeItemModel]);

        $serializer = new ListWithAvailableSizeCommandSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListWithAvailableSizeCommandSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new ListWithAvailableSizeCommand([$alternativeItemModel]))
            ->setName('test-name')
            ->setDescription('test-description')
            ->setArgumentType('test-argument-type')
            ->setSupportedValues('test-supported-values');

        $serializer = new ListWithAvailableSizeCommandSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListWithAvailableSizeCommandSerializerInterface::KEY_NAME => 'test-name',
                ListWithAvailableSizeCommandSerializerInterface::KEY_DESCRIPTION => 'test-description',
                ListWithAvailableSizeCommandSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                ListWithAvailableSizeCommandSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                ListWithAvailableSizeCommandSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            ],
            $serializer->serialize($model)
        );
    }
}
