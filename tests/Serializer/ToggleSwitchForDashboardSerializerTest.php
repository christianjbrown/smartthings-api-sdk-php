<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboard;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ToggleSwitchForDashboard::class)]
#[CoversClass(ToggleSwitchForDashboardSerializer::class)]
final class ToggleSwitchForDashboardSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandSerializer = self::createStub(ToggleSwitchForDashboardCommandSerializerInterface::class);
        $toggleSwitchForDashboardCommandSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-command']);
        $toggleSwitchForDashboardStateModel = self::createStub(ToggleSwitchForDashboardStateInterface::class);
        $toggleSwitchForDashboardStateSerializer = self::createStub(ToggleSwitchForDashboardStateSerializerInterface::class);
        $toggleSwitchForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard-state']);
        $model = new ToggleSwitchForDashboard($toggleSwitchForDashboardCommandModel);

        $serializer = new ToggleSwitchForDashboardSerializer($toggleSwitchForDashboardCommandSerializer, $toggleSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                ToggleSwitchForDashboardSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
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
        $model = (new ToggleSwitchForDashboard($toggleSwitchForDashboardCommandModel))
            ->setState($toggleSwitchForDashboardStateModel);

        $serializer = new ToggleSwitchForDashboardSerializer($toggleSwitchForDashboardCommandSerializer, $toggleSwitchForDashboardStateSerializer);

        self::assertSame(
            [
                ToggleSwitchForDashboardSerializerInterface::KEY_COMMAND => ['test-serialized-toggle-switch-for-dashboard-command'],
                ToggleSwitchForDashboardSerializerInterface::KEY_STATE => ['test-serialized-toggle-switch-for-dashboard-state'],
            ],
            $serializer->serialize($model)
        );
    }
}
