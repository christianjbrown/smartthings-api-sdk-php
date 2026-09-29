<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\CapabilityValueForDashboardState;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForDashboardStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityValueForDashboardState::class)]
#[CoversClass(CapabilityValueForDashboardStateSerializer::class)]
final class CapabilityValueForDashboardStateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new CapabilityValueForDashboardState();

        $serializer = new CapabilityValueForDashboardStateSerializer($alternativeItemSerializer);

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
        $model = (new CapabilityValueForDashboardState())
            ->setLabel('test-label')
            ->setAlternatives([$alternativeItemModel]);

        $serializer = new CapabilityValueForDashboardStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                CapabilityValueForDashboardStateSerializerInterface::KEY_LABEL => 'test-label',
                CapabilityValueForDashboardStateSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
