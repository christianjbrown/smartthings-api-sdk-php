<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SwitchForDashboard;
use ChristianBrown\SmartThings\Model\SwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;

use function is_array;

final class SwitchForDashboardTransformer implements SwitchForDashboardTransformerInterface
{
    private ToggleSwitchForDashboardCommandTransformerInterface $toggleSwitchForDashboardCommandTransformer;
    private ToggleSwitchForDashboardStateTransformerInterface $toggleSwitchForDashboardStateTransformer;

    public function __construct(ToggleSwitchForDashboardCommandTransformerInterface $toggleSwitchForDashboardCommandTransformer, ToggleSwitchForDashboardStateTransformerInterface $toggleSwitchForDashboardStateTransformer)
    {
        $this->toggleSwitchForDashboardCommandTransformer = $toggleSwitchForDashboardCommandTransformer;
        $this->toggleSwitchForDashboardStateTransformer = $toggleSwitchForDashboardStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SwitchForDashboardInterface
    {
        $model = new SwitchForDashboard($this->requireCommand($data));

        $this->applyState($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(SwitchForDashboard $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($this->toggleSwitchForDashboardStateTransformer->transform($data[self::KEY_STATE]));
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
