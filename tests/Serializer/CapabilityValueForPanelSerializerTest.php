<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\CapabilityValueForPanel;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForPanelSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForPanelSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityValueForPanel::class)]
#[CoversClass(CapabilityValueForPanelSerializer::class)]
final class CapabilityValueForPanelSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new CapabilityValueForPanel();

        $serializer = new CapabilityValueForPanelSerializer($alternativeItemSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new CapabilityValueForPanel())
            ->setEnabledValues(['test-enabled-values-1', 'test-enabled-values-2'])
            ->setLabel('test-label')
            ->setAlternatives([$alternativeItemModel])
            ->setRange(['test-range-key' => 'test-value'])
            ->setStep(1.5)
            ->setKey('test-key');

        $serializer = new CapabilityValueForPanelSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                CapabilityValueForPanelSerializerInterface::KEY_ENABLED_VALUES => ['test-enabled-values-1', 'test-enabled-values-2'],
                CapabilityValueForPanelSerializerInterface::KEY_LABEL => 'test-label',
                CapabilityValueForPanelSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                CapabilityValueForPanelSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                CapabilityValueForPanelSerializerInterface::KEY_STEP => 1.5,
                CapabilityValueForPanelSerializerInterface::KEY_KEY => 'test-key',
            ],
            $serializer->serialize($model)
        );
    }
}
