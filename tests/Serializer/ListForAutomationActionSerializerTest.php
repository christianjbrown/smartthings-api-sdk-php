<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationAction;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\ListForAutomationActionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ListForAutomationAction::class)]
#[CoversClass(ListForAutomationActionSerializer::class)]
final class ListForAutomationActionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new ListForAutomationAction([$alternativeItemModel]);

        $serializer = new ListForAutomationActionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListForAutomationActionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new ListForAutomationAction([$alternativeItemModel]))
            ->setSupportedValues('test-supported-values')
            ->setCommand('test-command')
            ->setArgumentType('test-argument-type');

        $serializer = new ListForAutomationActionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListForAutomationActionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                ListForAutomationActionSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                ListForAutomationActionSerializerInterface::KEY_COMMAND => 'test-command',
                ListForAutomationActionSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ],
            $serializer->serialize($model)
        );
    }
}
