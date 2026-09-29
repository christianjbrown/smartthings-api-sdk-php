<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\CapabilityValue;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityValueSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityValueSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityValue::class)]
#[CoversClass(CapabilityValueSerializer::class)]
final class CapabilityValueSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new CapabilityValue('test-key');

        $serializer = new CapabilityValueSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                CapabilityValueSerializerInterface::KEY_KEY => 'test-key',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new CapabilityValue('test-key'))
            ->setEnabledValues(['test-enabled-values-1', 'test-enabled-values-2'])
            ->setLabel('test-label')
            ->setAlternatives([$alternativeItemModel])
            ->setRange(['test-range-key' => 'test-value'])
            ->setStep(1.5);

        $serializer = new CapabilityValueSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                CapabilityValueSerializerInterface::KEY_ENABLED_VALUES => ['test-enabled-values-1', 'test-enabled-values-2'],
                CapabilityValueSerializerInterface::KEY_LABEL => 'test-label',
                CapabilityValueSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                CapabilityValueSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                CapabilityValueSerializerInterface::KEY_STEP => 1.5,
                CapabilityValueSerializerInterface::KEY_KEY => 'test-key',
            ],
            $serializer->serialize($model)
        );
    }
}
