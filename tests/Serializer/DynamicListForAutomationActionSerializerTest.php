<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationAction;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationActionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DynamicListForAutomationAction::class)]
#[CoversClass(DynamicListForAutomationActionSerializer::class)]
final class DynamicListForAutomationActionSerializerTest extends TestCase
{
    public function testSerializeNestedAbsent(): void
    {
        $supportedValuesForDynamicListSerializer = self::createStub(SupportedValuesForDynamicListSerializerInterface::class);
        $supportedValuesForDynamicListSerializer->method('serialize')->willReturn(['test-serialized-supported-values-for-dynamic-list']);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new DynamicListForAutomationAction(null);

        $serializer = new DynamicListForAutomationActionSerializer($supportedValuesForDynamicListSerializer, $alternativeItemSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeRequiredFieldsOnly(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListSerializer = self::createStub(SupportedValuesForDynamicListSerializerInterface::class);
        $supportedValuesForDynamicListSerializer->method('serialize')->willReturn(['test-serialized-supported-values-for-dynamic-list']);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new DynamicListForAutomationAction($supportedValuesForDynamicListModel);

        $serializer = new DynamicListForAutomationActionSerializer($supportedValuesForDynamicListSerializer, $alternativeItemSerializer);

        self::assertSame(
            [
                DynamicListForAutomationActionSerializerInterface::KEY_SUPPORTED_VALUES => ['test-serialized-supported-values-for-dynamic-list'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListSerializer = self::createStub(SupportedValuesForDynamicListSerializerInterface::class);
        $supportedValuesForDynamicListSerializer->method('serialize')->willReturn(['test-serialized-supported-values-for-dynamic-list']);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new DynamicListForAutomationAction($supportedValuesForDynamicListModel))
            ->setCommand('test-command')
            ->setArgumentType('test-argument-type')
            ->setAlternatives([$alternativeItemModel]);

        $serializer = new DynamicListForAutomationActionSerializer($supportedValuesForDynamicListSerializer, $alternativeItemSerializer);

        self::assertSame(
            [
                DynamicListForAutomationActionSerializerInterface::KEY_COMMAND => 'test-command',
                DynamicListForAutomationActionSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                DynamicListForAutomationActionSerializerInterface::KEY_SUPPORTED_VALUES => ['test-serialized-supported-values-for-dynamic-list'],
                DynamicListForAutomationActionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
