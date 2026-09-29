<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapability;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItemInterface;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItemInterface;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityActionsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityConditionsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilitySerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AutomationForCapability::class)]
#[CoversClass(AutomationForCapabilitySerializer::class)]
final class AutomationForCapabilitySerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $automationForCapabilityConditionsItemModel = self::createStub(AutomationForCapabilityConditionsItemInterface::class);
        $automationForCapabilityConditionsItemSerializer = self::createStub(AutomationForCapabilityConditionsItemSerializerInterface::class);
        $automationForCapabilityConditionsItemSerializer->method('serialize')->willReturn(['test-serialized-automation-for-capability-conditions-item']);
        $automationForCapabilityActionsItemModel = self::createStub(AutomationForCapabilityActionsItemInterface::class);
        $automationForCapabilityActionsItemSerializer = self::createStub(AutomationForCapabilityActionsItemSerializerInterface::class);
        $automationForCapabilityActionsItemSerializer->method('serialize')->willReturn(['test-serialized-automation-for-capability-actions-item']);
        $model = new AutomationForCapability();

        $serializer = new AutomationForCapabilitySerializer($automationForCapabilityConditionsItemSerializer, $automationForCapabilityActionsItemSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $automationForCapabilityConditionsItemModel = self::createStub(AutomationForCapabilityConditionsItemInterface::class);
        $automationForCapabilityConditionsItemSerializer = self::createStub(AutomationForCapabilityConditionsItemSerializerInterface::class);
        $automationForCapabilityConditionsItemSerializer->method('serialize')->willReturn(['test-serialized-automation-for-capability-conditions-item']);
        $automationForCapabilityActionsItemModel = self::createStub(AutomationForCapabilityActionsItemInterface::class);
        $automationForCapabilityActionsItemSerializer = self::createStub(AutomationForCapabilityActionsItemSerializerInterface::class);
        $automationForCapabilityActionsItemSerializer->method('serialize')->willReturn(['test-serialized-automation-for-capability-actions-item']);
        $model = (new AutomationForCapability())
            ->setConditions([$automationForCapabilityConditionsItemModel])
            ->setActions([$automationForCapabilityActionsItemModel]);

        $serializer = new AutomationForCapabilitySerializer($automationForCapabilityConditionsItemSerializer, $automationForCapabilityActionsItemSerializer);

        self::assertSame(
            [
                AutomationForCapabilitySerializerInterface::KEY_CONDITIONS => [['test-serialized-automation-for-capability-conditions-item']],
                AutomationForCapabilitySerializerInterface::KEY_ACTIONS => [['test-serialized-automation-for-capability-actions-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
