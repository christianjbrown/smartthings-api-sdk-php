<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ActionItem;
use ChristianBrown\SmartThings\Model\PlayPauseInterface;
use ChristianBrown\SmartThings\Model\PlayStopInterface;
use ChristianBrown\SmartThings\Model\PushButtonInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboardInterface;
use ChristianBrown\SmartThings\Model\SwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardInterface;
use ChristianBrown\SmartThings\Serializer\ActionItemSerializer;
use ChristianBrown\SmartThings\Serializer\ActionItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayPauseSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayStopSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PushButtonSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StatelessPowerToggleForDashboardSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SwitchForDashboardSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ActionItem::class)]
#[CoversClass(ActionItemSerializer::class)]
final class ActionItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonSerializer = self::createStub(PushButtonSerializerInterface::class);
        $pushButtonSerializer->method('serialize')->willReturn(['test-serialized-push-button']);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardSerializer = self::createStub(ToggleSwitchForDashboardSerializerInterface::class);
        $toggleSwitchForDashboardSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard']);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardSerializer = self::createStub(SwitchForDashboardSerializerInterface::class);
        $switchForDashboardSerializer->method('serialize')->willReturn(['test-serialized-switch-for-dashboard']);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardSerializer = self::createStub(StandbyPowerSwitchForDashboardSerializerInterface::class);
        $standbyPowerSwitchForDashboardSerializer->method('serialize')->willReturn(['test-serialized-standby-power-switch-for-dashboard']);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardSerializer = self::createStub(StatelessPowerToggleForDashboardSerializerInterface::class);
        $statelessPowerToggleForDashboardSerializer->method('serialize')->willReturn(['test-serialized-stateless-power-toggle-for-dashboard']);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseSerializer = self::createStub(PlayPauseSerializerInterface::class);
        $playPauseSerializer->method('serialize')->willReturn(['test-serialized-play-pause']);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopSerializer = self::createStub(PlayStopSerializerInterface::class);
        $playStopSerializer->method('serialize')->willReturn(['test-serialized-play-stop']);
        $model = new ActionItem('test-display-type');

        $serializer = new ActionItemSerializer($pushButtonSerializer, $toggleSwitchForDashboardSerializer, $switchForDashboardSerializer, $standbyPowerSwitchForDashboardSerializer, $statelessPowerToggleForDashboardSerializer, $playPauseSerializer, $playStopSerializer);

        self::assertSame(
            [
                ActionItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonSerializer = self::createStub(PushButtonSerializerInterface::class);
        $pushButtonSerializer->method('serialize')->willReturn(['test-serialized-push-button']);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardSerializer = self::createStub(ToggleSwitchForDashboardSerializerInterface::class);
        $toggleSwitchForDashboardSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch-for-dashboard']);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardSerializer = self::createStub(SwitchForDashboardSerializerInterface::class);
        $switchForDashboardSerializer->method('serialize')->willReturn(['test-serialized-switch-for-dashboard']);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardSerializer = self::createStub(StandbyPowerSwitchForDashboardSerializerInterface::class);
        $standbyPowerSwitchForDashboardSerializer->method('serialize')->willReturn(['test-serialized-standby-power-switch-for-dashboard']);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardSerializer = self::createStub(StatelessPowerToggleForDashboardSerializerInterface::class);
        $statelessPowerToggleForDashboardSerializer->method('serialize')->willReturn(['test-serialized-stateless-power-toggle-for-dashboard']);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseSerializer = self::createStub(PlayPauseSerializerInterface::class);
        $playPauseSerializer->method('serialize')->willReturn(['test-serialized-play-pause']);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopSerializer = self::createStub(PlayStopSerializerInterface::class);
        $playStopSerializer->method('serialize')->willReturn(['test-serialized-play-stop']);
        $model = (new ActionItem('test-display-type'))
            ->setPushButton($pushButtonModel)
            ->setToggleSwitch($toggleSwitchForDashboardModel)
            ->setSwitch($switchForDashboardModel)
            ->setStandbyPowerSwitch($standbyPowerSwitchForDashboardModel)
            ->setStatelessPowerToggle($statelessPowerToggleForDashboardModel)
            ->setPlayPause($playPauseModel)
            ->setPlayStop($playStopModel)
            ->setGroup('test-group');

        $serializer = new ActionItemSerializer($pushButtonSerializer, $toggleSwitchForDashboardSerializer, $switchForDashboardSerializer, $standbyPowerSwitchForDashboardSerializer, $statelessPowerToggleForDashboardSerializer, $playPauseSerializer, $playStopSerializer);

        self::assertSame(
            [
                ActionItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
                ActionItemSerializerInterface::KEY_PUSH_BUTTON => ['test-serialized-push-button'],
                ActionItemSerializerInterface::KEY_TOGGLE_SWITCH => ['test-serialized-toggle-switch-for-dashboard'],
                ActionItemSerializerInterface::KEY_SWITCH => ['test-serialized-switch-for-dashboard'],
                ActionItemSerializerInterface::KEY_STANDBY_POWER_SWITCH => ['test-serialized-standby-power-switch-for-dashboard'],
                ActionItemSerializerInterface::KEY_STATELESS_POWER_TOGGLE => ['test-serialized-stateless-power-toggle-for-dashboard'],
                ActionItemSerializerInterface::KEY_PLAY_PAUSE => ['test-serialized-play-pause'],
                ActionItemSerializerInterface::KEY_PLAY_STOP => ['test-serialized-play-stop'],
                ActionItemSerializerInterface::KEY_GROUP => 'test-group',
            ],
            $serializer->serialize($model)
        );
    }
}
