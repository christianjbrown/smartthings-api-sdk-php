<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\StandbyPowerSwitch;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardStateSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchSerializer;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StandbyPowerSwitch::class)]
#[CoversClass(StandbyPowerSwitchSerializer::class)]
final class StandbyPowerSwitchSerializerTest extends TestCase
{
    public function testSerializeNestedAbsent(): void
    {
        $toggleSwitchForDashboardCommandSerializer = self::createStub(ToggleSwitchForDashboardCommandSerializerInterface::class);
        $toggleSwitchForDashboardCommandSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-command']);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer = self::createStub(StandbyPowerSwitchForDashboardStateSerializerInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-standby-power-switch-for-dashboard-state']);
        $model = new StandbyPowerSwitch(null);

        $serializer = new StandbyPowerSwitchSerializer($toggleSwitchForDashboardCommandSerializer, $standbyPowerSwitchForDashboardStateSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeRequiredFieldsOnly(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandSerializer = self::createStub(ToggleSwitchForDashboardCommandSerializerInterface::class);
        $toggleSwitchForDashboardCommandSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-command']);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer = self::createStub(StandbyPowerSwitchForDashboardStateSerializerInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-standby-power-switch-for-dashboard-state']);
        $model = new StandbyPowerSwitch($toggleSwitchForDashboardCommandModel);

        $serializer = new StandbyPowerSwitchSerializer($toggleSwitchForDashboardCommandSerializer, $standbyPowerSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                StandbyPowerSwitchSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandSerializer = self::createStub(ToggleSwitchForDashboardCommandSerializerInterface::class);
        $toggleSwitchForDashboardCommandSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-command']);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer = self::createStub(StandbyPowerSwitchForDashboardStateSerializerInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-standby-power-switch-for-dashboard-state']);
        $model = (new StandbyPowerSwitch($toggleSwitchForDashboardCommandModel))
            ->setState($standbyPowerSwitchForDashboardStateModel);

        $serializer = new StandbyPowerSwitchSerializer($toggleSwitchForDashboardCommandSerializer, $standbyPowerSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                StandbyPowerSwitchSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
                StandbyPowerSwitchSerializerInterface::KEY_STATE => ['test-serialized-standby-power-switch-for-dashboard-state'],
            ],
            $serializer->serialize($model)
        );
    }
}
