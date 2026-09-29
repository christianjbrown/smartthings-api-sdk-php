<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboard;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardInterface;

use function is_array;
use function sprintf;

final class ToggleSwitchForDashboardTransformer implements ToggleSwitchForDashboardTransformerInterface
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
    public function transform(array $data): ToggleSwitchForDashboardInterface
    {
        $model = new ToggleSwitchForDashboard($this->requireCommand($data));

        $this->applyState($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(ToggleSwitchForDashboard $model, array $data): void
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
