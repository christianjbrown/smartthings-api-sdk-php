<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardState;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ToggleSwitchForDashboardState::class)]
#[CoversClass(ToggleSwitchForDashboardStateSerializer::class)]
final class ToggleSwitchForDashboardStateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new ToggleSwitchForDashboardState('test-on', 'test-off');

        $serializer = new ToggleSwitchForDashboardStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ToggleSwitchForDashboardStateSerializerInterface::KEY_ON => 'test-on',
                ToggleSwitchForDashboardStateSerializerInterface::KEY_OFF => 'test-off',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new ToggleSwitchForDashboardState('test-on', 'test-off'))
            ->setValue('test-value')
            ->setValueType('test-value-type')
            ->setAlternatives([$alternativeItemModel]);

        $serializer = new ToggleSwitchForDashboardStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ToggleSwitchForDashboardStateSerializerInterface::KEY_VALUE => 'test-value',
                ToggleSwitchForDashboardStateSerializerInterface::KEY_ON => 'test-on',
                ToggleSwitchForDashboardStateSerializerInterface::KEY_OFF => 'test-off',
                ToggleSwitchForDashboardStateSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                ToggleSwitchForDashboardStateSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
