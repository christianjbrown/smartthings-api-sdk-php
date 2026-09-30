<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ToggleSwitch;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchInterface;

use function is_array;

final class ToggleSwitchTransformer implements ToggleSwitchTransformerInterface
{
    private StandbyPowerSwitchForDashboardStateTransformerInterface $standbyPowerSwitchForDashboardStateTransformer;
    private ToggleSwitchForDashboardCommandTransformerInterface $toggleSwitchForDashboardCommandTransformer;

    public function __construct(ToggleSwitchForDashboardCommandTransformerInterface $toggleSwitchForDashboardCommandTransformer, StandbyPowerSwitchForDashboardStateTransformerInterface $standbyPowerSwitchForDashboardStateTransformer)
    {
        $this->toggleSwitchForDashboardCommandTransformer = $toggleSwitchForDashboardCommandTransformer;
        $this->standbyPowerSwitchForDashboardStateTransformer = $standbyPowerSwitchForDashboardStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ToggleSwitchInterface
    {
        $model = new ToggleSwitch($this->requireCommand($data));

        $this->applyState($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(ToggleSwitch $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($this->standbyPowerSwitchForDashboardStateTransformer->transform($data[self::KEY_STATE]));
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): ?ToggleSwitchForDashboardCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            return null;
        }

        return $this->toggleSwitchForDashboardCommandTransformer->transform($data[self::KEY_COMMAND]);
    }
}
