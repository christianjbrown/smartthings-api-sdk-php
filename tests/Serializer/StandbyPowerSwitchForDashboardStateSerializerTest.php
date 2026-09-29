<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardState;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StandbyPowerSwitchForDashboardState::class)]
#[CoversClass(StandbyPowerSwitchForDashboardStateSerializer::class)]
final class StandbyPowerSwitchForDashboardStateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new StandbyPowerSwitchForDashboardState('test-value', 'test-on', 'test-off');

        $serializer = new StandbyPowerSwitchForDashboardStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StandbyPowerSwitchForDashboardStateSerializerInterface::KEY_VALUE => 'test-value',
                StandbyPowerSwitchForDashboardStateSerializerInterface::KEY_ON => 'test-on',
                StandbyPowerSwitchForDashboardStateSerializerInterface::KEY_OFF => 'test-off',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new StandbyPowerSwitchForDashboardState('test-value', 'test-on', 'test-off'))
            ->setValueType('test-value-type')
            ->setLabel('test-label')
            ->setAlternatives([$alternativeItemModel]);

        $serializer = new StandbyPowerSwitchForDashboardStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StandbyPowerSwitchForDashboardStateSerializerInterface::KEY_VALUE => 'test-value',
                StandbyPowerSwitchForDashboardStateSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                StandbyPowerSwitchForDashboardStateSerializerInterface::KEY_ON => 'test-on',
                StandbyPowerSwitchForDashboardStateSerializerInterface::KEY_OFF => 'test-off',
                StandbyPowerSwitchForDashboardStateSerializerInterface::KEY_LABEL => 'test-label',
                StandbyPowerSwitchForDashboardStateSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
