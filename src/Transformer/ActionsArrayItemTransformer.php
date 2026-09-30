<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionsArrayItem;
use ChristianBrown\SmartThings\Model\ActionsArrayItemInterface;

use function is_array;
use function is_int;
use function is_string;

final class ActionsArrayItemTransformer implements ActionsArrayItemTransformerInterface
{
    private PlayPauseTransformerInterface $playPauseTransformer;
    private PlayStopTransformerInterface $playStopTransformer;
    private PushButtonTransformerInterface $pushButtonTransformer;
    private StandbyPowerSwitchForDashboardTransformerInterface $standbyPowerSwitchForDashboardTransformer;
    private StatelessPowerToggleForDashboardTransformerInterface $statelessPowerToggleForDashboardTransformer;
    private SwitchForDashboardTransformerInterface $switchForDashboardTransformer;
    private ToggleSwitchForDashboardTransformerInterface $toggleSwitchForDashboardTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(PushButtonTransformerInterface $pushButtonTransformer, ToggleSwitchForDashboardTransformerInterface $toggleSwitchForDashboardTransformer, SwitchForDashboardTransformerInterface $switchForDashboardTransformer, StandbyPowerSwitchForDashboardTransformerInterface $standbyPowerSwitchForDashboardTransformer, StatelessPowerToggleForDashboardTransformerInterface $statelessPowerToggleForDashboardTransformer, PlayPauseTransformerInterface $playPauseTransformer, PlayStopTransformerInterface $playStopTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->pushButtonTransformer = $pushButtonTransformer;
        $this->toggleSwitchForDashboardTransformer = $toggleSwitchForDashboardTransformer;
        $this->switchForDashboardTransformer = $switchForDashboardTransformer;
        $this->standbyPowerSwitchForDashboardTransformer = $standbyPowerSwitchForDashboardTransformer;
        $this->statelessPowerToggleForDashboardTransformer = $statelessPowerToggleForDashboardTransformer;
        $this->playPauseTransformer = $playPauseTransformer;
        $this->playStopTransformer = $playStopTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ActionsArrayItemInterface
    {
        $model = new ActionsArrayItem(self::requireDisplayType($data), self::requireCapability($data));

        $this->applyPushButton($model, $data);
        $this->applyToggleSwitch($model, $data);
        $this->applySwitch($model, $data);
        $this->applyStandbyPowerSwitch($model, $data);
        $this->applyStatelessPowerToggle($model, $data);
        $this->applyPlayPause($model, $data);
        $this->applyPlayStop($model, $data);
        self::applyGroup($model, $data);
        self::applyVersion($model, $data);
        self::applyComponent($model, $data);
        $this->applyVisibleCondition($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComponent(ActionsArrayItem $model, array $data): void
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return;
        }
        $model->setComponent($data[self::KEY_COMPONENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGroup(ActionsArrayItem $model, array $data): void
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
    private function applyPlayPause(ActionsArrayItem $model, array $data): void
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
    private function applyPlayStop(ActionsArrayItem $model, array $data): void
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
    private function applyPushButton(ActionsArrayItem $model, array $data): void
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
    private function applyStandbyPowerSwitch(ActionsArrayItem $model, array $data): void
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
    private function applyStatelessPowerToggle(ActionsArrayItem $model, array $data): void
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
    private function applySwitch(ActionsArrayItem $model, array $data): void
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
    private function applyToggleSwitch(ActionsArrayItem $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(ActionsArrayItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVisibleCondition(ActionsArrayItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        $model->setVisibleCondition($this->visibleConditionTransformer->transform($data[self::KEY_VISIBLE_CONDITION]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY];
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
