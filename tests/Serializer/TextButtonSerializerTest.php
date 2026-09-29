<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\TextButton;
use ChristianBrown\SmartThings\Model\TextButtonButtonsItemInterface;
use ChristianBrown\SmartThings\Serializer\TextButtonButtonsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\TextButtonSerializer;
use ChristianBrown\SmartThings\Serializer\TextButtonSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextButton::class)]
#[CoversClass(TextButtonSerializer::class)]
final class TextButtonSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $textButtonButtonsItemModel = self::createStub(TextButtonButtonsItemInterface::class);
        $textButtonButtonsItemSerializer = self::createStub(TextButtonButtonsItemSerializerInterface::class);
        $textButtonButtonsItemSerializer->method('serialize')->willReturn(['test-serialized-text-button-buttons-item']);
        $model = new TextButton([$textButtonButtonsItemModel]);

        $serializer = new TextButtonSerializer($textButtonButtonsItemSerializer);

        self::assertSame(
            [
                TextButtonSerializerInterface::KEY_BUTTONS => [['test-serialized-text-button-buttons-item']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $textButtonButtonsItemModel = self::createStub(TextButtonButtonsItemInterface::class);
        $textButtonButtonsItemSerializer = self::createStub(TextButtonButtonsItemSerializerInterface::class);
        $textButtonButtonsItemSerializer->method('serialize')->willReturn(['test-serialized-text-button-buttons-item']);
        $model = (new TextButton([$textButtonButtonsItemModel]))
            ->setCommand('test-command')
            ->setValue('test-value')
            ->setSupportedValues('test-supported-values');

        $serializer = new TextButtonSerializer($textButtonButtonsItemSerializer);

        self::assertSame(
            [
                TextButtonSerializerInterface::KEY_COMMAND => 'test-command',
                TextButtonSerializerInterface::KEY_VALUE => 'test-value',
                TextButtonSerializerInterface::KEY_BUTTONS => [['test-serialized-text-button-buttons-item']],
                TextButtonSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            ],
            $serializer->serialize($model)
        );
    }
}
