<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitch;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardStateSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchSerializer;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ToggleSwitch::class)]
#[CoversClass(ToggleSwitchSerializer::class)]
final class ToggleSwitchSerializerTest extends TestCase
{
    public function testSerializeNestedAbsent(): void
    {
        $toggleSwitchForDashboardCommandSerializer = self::createStub(ToggleSwitchForDashboardCommandSerializerInterface::class);
        $toggleSwitchForDashboardCommandSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-command']);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer = self::createStub(StandbyPowerSwitchForDashboardStateSerializerInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-standby-power-switch-for-dashboard-state']);
        $model = new ToggleSwitch(null);

        $serializer = new ToggleSwitchSerializer($toggleSwitchForDashboardCommandSerializer, $standbyPowerSwitchForDashboardStateSerializer);

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
        $model = new ToggleSwitch($toggleSwitchForDashboardCommandModel);

        $serializer = new ToggleSwitchSerializer($toggleSwitchForDashboardCommandSerializer, $standbyPowerSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                ToggleSwitchSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
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
        $model = (new ToggleSwitch($toggleSwitchForDashboardCommandModel))
            ->setState($standbyPowerSwitchForDashboardStateModel);

        $serializer = new ToggleSwitchSerializer($toggleSwitchForDashboardCommandSerializer, $standbyPowerSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                ToggleSwitchSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
                ToggleSwitchSerializerInterface::KEY_STATE => ['test-serialized-standby-power-switch-for-dashboard-state'],
            ],
            $serializer->serialize($model)
        );
    }
}
