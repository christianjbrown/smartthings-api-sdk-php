<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboard;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardStateSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StandbyPowerSwitchForDashboard::class)]
#[CoversClass(StandbyPowerSwitchForDashboardSerializer::class)]
final class StandbyPowerSwitchForDashboardSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandSerializer = self::createStub(ToggleSwitchForDashboardCommandSerializerInterface::class);
        $toggleSwitchForDashboardCommandSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-command']);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer = self::createStub(StandbyPowerSwitchForDashboardStateSerializerInterface::class);
        $standbyPowerSwitchForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-standby-power-switch-for-dashboard-state']);
        $model = new StandbyPowerSwitchForDashboard($toggleSwitchForDashboardCommandModel);

        $serializer = new StandbyPowerSwitchForDashboardSerializer($toggleSwitchForDashboardCommandSerializer, $standbyPowerSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                StandbyPowerSwitchForDashboardSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
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
        $model = (new StandbyPowerSwitchForDashboard($toggleSwitchForDashboardCommandModel))
            ->setState($standbyPowerSwitchForDashboardStateModel);

        $serializer = new StandbyPowerSwitchForDashboardSerializer($toggleSwitchForDashboardCommandSerializer, $standbyPowerSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                StandbyPowerSwitchForDashboardSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
                StandbyPowerSwitchForDashboardSerializerInterface::KEY_STATE => ['test-serialized-standby-power-switch-for-dashboard-state'],
            ],
            $serializer->serialize($model)
        );
    }
}
