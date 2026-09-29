<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\SwitchForDashboard;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Serializer\SwitchForDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\SwitchForDashboardSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SwitchForDashboard::class)]
#[CoversClass(SwitchForDashboardSerializer::class)]
final class SwitchForDashboardSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandSerializer = self::createStub(ToggleSwitchForDashboardCommandSerializerInterface::class);
        $toggleSwitchForDashboardCommandSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-command']);
        $toggleSwitchForDashboardStateModel = self::createStub(ToggleSwitchForDashboardStateInterface::class);
        $toggleSwitchForDashboardStateSerializer = self::createStub(ToggleSwitchForDashboardStateSerializerInterface::class);
        $toggleSwitchForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-state']);
        $model = new SwitchForDashboard($toggleSwitchForDashboardCommandModel);

        $serializer = new SwitchForDashboardSerializer($toggleSwitchForDashboardCommandSerializer, $toggleSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                SwitchForDashboardSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandSerializer = self::createStub(ToggleSwitchForDashboardCommandSerializerInterface::class);
        $toggleSwitchForDashboardCommandSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-command']);
        $toggleSwitchForDashboardStateModel = self::createStub(ToggleSwitchForDashboardStateInterface::class);
        $toggleSwitchForDashboardStateSerializer = self::createStub(ToggleSwitchForDashboardStateSerializerInterface::class);
        $toggleSwitchForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-state']);
        $model = (new SwitchForDashboard($toggleSwitchForDashboardCommandModel))
            ->setState($toggleSwitchForDashboardStateModel);

        $serializer = new SwitchForDashboardSerializer($toggleSwitchForDashboardCommandSerializer, $toggleSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                SwitchForDashboardSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
                SwitchForDashboardSerializerInterface::KEY_STATE => ['test-serialized-toggle-switch-for-dashboard-state'],
            ],
            $serializer->serialize($model)
        );
    }
}
