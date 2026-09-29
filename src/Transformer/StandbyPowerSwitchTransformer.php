<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitch;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;

use function is_array;
use function sprintf;

final class StandbyPowerSwitchTransformer implements StandbyPowerSwitchTransformerInterface
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
    public function transform(array $data): StandbyPowerSwitchInterface
    {
        $model = new StandbyPowerSwitch($this->requireCommand($data));

        $this->applyState($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(StandbyPowerSwitch $model, array $data): void
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
    private function requireCommand(array $data): ToggleSwitchForDashboardCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }

        return $this->toggleSwitchForDashboardCommandTransformer->transform($data[self::KEY_COMMAND]);
    }
}
