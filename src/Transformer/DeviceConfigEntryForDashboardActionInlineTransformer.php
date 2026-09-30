<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInline;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInlineInterface;

use function is_array;
use function is_string;

final class DeviceConfigEntryForDashboardActionInlineTransformer implements DeviceConfigEntryForDashboardActionInlineTransformerInterface
{
    private PlayPauseTransformerInterface $playPauseTransformer;
    private PlayStopTransformerInterface $playStopTransformer;
    private PushButtonTransformerInterface $pushButtonTransformer;
    private StandbyPowerSwitchForDashboardTransformerInterface $standbyPowerSwitchForDashboardTransformer;
    private StatelessPowerToggleForDashboardTransformerInterface $statelessPowerToggleForDashboardTransformer;
    private SwitchForDashboardTransformerInterface $switchForDashboardTransformer;
    private ToggleSwitchForDashboardTransformerInterface $toggleSwitchForDashboardTransformer;

    public function __construct(PushButtonTransformerInterface $pushButtonTransformer, ToggleSwitchForDashboardTransformerInterface $toggleSwitchForDashboardTransformer, SwitchForDashboardTransformerInterface $switchForDashboardTransformer, StandbyPowerSwitchForDashboardTransformerInterface $standbyPowerSwitchForDashboardTransformer, StatelessPowerToggleForDashboardTransformerInterface $statelessPowerToggleForDashboardTransformer, PlayPauseTransformerInterface $playPauseTransformer, PlayStopTransformerInterface $playStopTransformer)
    {
        $this->pushButtonTransformer = $pushButtonTransformer;
        $this->toggleSwitchForDashboardTransformer = $toggleSwitchForDashboardTransformer;
        $this->switchForDashboardTransformer = $switchForDashboardTransformer;
        $this->standbyPowerSwitchForDashboardTransformer = $standbyPowerSwitchForDashboardTransformer;
        $this->statelessPowerToggleForDashboardTransformer = $statelessPowerToggleForDashboardTransformer;
        $this->playPauseTransformer = $playPauseTransformer;
        $this->playStopTransformer = $playStopTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigEntryForDashboardActionInlineInterface
    {
        $model = new DeviceConfigEntryForDashboardActionInline(self::requireDisplayType($data));

        $this->applyPushButton($model, $data);
        $this->applyToggleSwitch($model, $data);
        $this->applySwitch($model, $data);
        $this->applyStandbyPowerSwitch($model, $data);
        $this->applyStatelessPowerToggle($model, $data);
        $this->applyPlayPause($model, $data);
        $this->applyPlayStop($model, $data);
        self::applyGroup($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGroup(DeviceConfigEntryForDashboardActionInline $model, array $data): void
    {
        if (empty($data[self::KEY_GROUP])) {
            return;
        }
        if (!is_string($data[self::KEY_GROUP])) {
            return;
        }
        $model->setGroup($data[self::KEY_GROUP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPlayPause(DeviceConfigEntryForDashboardActionInline $model, array $data): void
    {
        if (!isset($data[self::KEY_PLAY_PAUSE])) {
            return;
        }
        if (!is_array($data[self::KEY_PLAY_PAUSE])) {
            return;
        }
        $model->setPlayPause($this->playPauseTransformer->transform($data[self::KEY_PLAY_PAUSE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPlayStop(DeviceConfigEntryForDashboardActionInline $model, array $data): void
    {
        if (!isset($data[self::KEY_PLAY_STOP])) {
            return;
        }
        if (!is_array($data[self::KEY_PLAY_STOP])) {
            return;
        }
        $model->setPlayStop($this->playStopTransformer->transform($data[self::KEY_PLAY_STOP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPushButton(DeviceConfigEntryForDashboardActionInline $model, array $data): void
    {
        if (!isset($data[self::KEY_PUSH_BUTTON])) {
            return;
        }
        if (!is_array($data[self::KEY_PUSH_BUTTON])) {
            return;
        }
        $model->setPushButton($this->pushButtonTransformer->transform($data[self::KEY_PUSH_BUTTON]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStandbyPowerSwitch(DeviceConfigEntryForDashboardActionInline $model, array $data): void
    {
        if (!isset($data[self::KEY_STANDBY_POWER_SWITCH])) {
            return;
        }
        if (!is_array($data[self::KEY_STANDBY_POWER_SWITCH])) {
            return;
        }
        $model->setStandbyPowerSwitch($this->standbyPowerSwitchForDashboardTransformer->transform($data[self::KEY_STANDBY_POWER_SWITCH]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStatelessPowerToggle(DeviceConfigEntryForDashboardActionInline $model, array $data): void
    {
        if (!isset($data[self::KEY_STATELESS_POWER_TOGGLE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATELESS_POWER_TOGGLE])) {
            return;
        }
        $model->setStatelessPowerToggle($this->statelessPowerToggleForDashboardTransformer->transform($data[self::KEY_STATELESS_POWER_TOGGLE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySwitch(DeviceConfigEntryForDashboardActionInline $model, array $data): void
    {
        if (!isset($data[self::KEY_SWITCH])) {
            return;
        }
        if (!is_array($data[self::KEY_SWITCH])) {
            return;
        }
        $model->setSwitch($this->switchForDashboardTransformer->transform($data[self::KEY_SWITCH]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyToggleSwitch(DeviceConfigEntryForDashboardActionInline $model, array $data): void
    {
        if (!isset($data[self::KEY_TOGGLE_SWITCH])) {
            return;
        }
        if (!is_array($data[self::KEY_TOGGLE_SWITCH])) {
            return;
        }
        $model->setToggleSwitch($this->toggleSwitchForDashboardTransformer->transform($data[self::KEY_TOGGLE_SWITCH]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDisplayType(array $data): ?string
    {
        if (empty($data[self::KEY_DISPLAY_TYPE])) {
            return null;
        }
        if (!is_string($data[self::KEY_DISPLAY_TYPE])) {
            return null;
        }

        return $data[self::KEY_DISPLAY_TYPE];
    }
}
