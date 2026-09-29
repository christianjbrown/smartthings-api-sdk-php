<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInlineInterface;
use ChristianBrown\SmartThings\Model\PlayPauseInterface;
use ChristianBrown\SmartThings\Model\PlayStopInterface;
use ChristianBrown\SmartThings\Model\PushButtonInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboardInterface;
use ChristianBrown\SmartThings\Model\SwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardInterface;

use function array_filter;

final class DeviceConfigEntryForDashboardActionInlineSerializer implements DeviceConfigEntryForDashboardActionInlineSerializerInterface
{
    private PlayPauseSerializerInterface $playPauseSerializer;
    private PlayStopSerializerInterface $playStopSerializer;
    private PushButtonSerializerInterface $pushButtonSerializer;
    private StandbyPowerSwitchForDashboardSerializerInterface $standbyPowerSwitchForDashboardSerializer;
    private StatelessPowerToggleForDashboardSerializerInterface $statelessPowerToggleForDashboardSerializer;
    private SwitchForDashboardSerializerInterface $switchForDashboardSerializer;
    private ToggleSwitchForDashboardSerializerInterface $toggleSwitchForDashboardSerializer;

    public function __construct(PushButtonSerializerInterface $pushButtonSerializer, ToggleSwitchForDashboardSerializerInterface $toggleSwitchForDashboardSerializer, SwitchForDashboardSerializerInterface $switchForDashboardSerializer, StandbyPowerSwitchForDashboardSerializerInterface $standbyPowerSwitchForDashboardSerializer, StatelessPowerToggleForDashboardSerializerInterface $statelessPowerToggleForDashboardSerializer, PlayPauseSerializerInterface $playPauseSerializer, PlayStopSerializerInterface $playStopSerializer)
    {
        $this->pushButtonSerializer = $pushButtonSerializer;
        $this->toggleSwitchForDashboardSerializer = $toggleSwitchForDashboardSerializer;
        $this->switchForDashboardSerializer = $switchForDashboardSerializer;
        $this->standbyPowerSwitchForDashboardSerializer = $standbyPowerSwitchForDashboardSerializer;
        $this->statelessPowerToggleForDashboardSerializer = $statelessPowerToggleForDashboardSerializer;
        $this->playPauseSerializer = $playPauseSerializer;
        $this->playStopSerializer = $playStopSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardActionInlineInterface $model): array
    {
        $serialized = [
            self::KEY_DISPLAY_TYPE => $model->getDisplayType(),
            self::KEY_PUSH_BUTTON => $this->serializeOptionalPushButton($model->getPushButton()),
            self::KEY_TOGGLE_SWITCH => $this->serializeOptionalToggleSwitch($model->getToggleSwitch()),
            self::KEY_SWITCH => $this->serializeOptionalSwitch($model->getSwitch()),
            self::KEY_STANDBY_POWER_SWITCH => $this->serializeOptionalStandbyPowerSwitch($model->getStandbyPowerSwitch()),
            self::KEY_STATELESS_POWER_TOGGLE => $this->serializeOptionalStatelessPowerToggle($model->getStatelessPowerToggle()),
            self::KEY_PLAY_PAUSE => $this->serializeOptionalPlayPause($model->getPlayPause()),
            self::KEY_PLAY_STOP => $this->serializeOptionalPlayStop($model->getPlayStop()),
            self::KEY_GROUP => $model->getGroup(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPlayPause(?PlayPauseInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->playPauseSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPlayStop(?PlayStopInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->playStopSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPushButton(?PushButtonInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->pushButtonSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalStandbyPowerSwitch(?StandbyPowerSwitchForDashboardInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->standbyPowerSwitchForDashboardSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalStatelessPowerToggle(?StatelessPowerToggleForDashboardInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->statelessPowerToggleForDashboardSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalSwitch(?SwitchForDashboardInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->switchForDashboardSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalToggleSwitch(?ToggleSwitchForDashboardInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->toggleSwitchForDashboardSerializer->serialize($value);
    }
}
