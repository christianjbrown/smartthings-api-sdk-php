<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboard;
use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboardInterface;

use function is_string;

final class StatelessPowerToggleForDashboardTransformer implements StatelessPowerToggleForDashboardTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StatelessPowerToggleForDashboardInterface
    {
        $model = new StatelessPowerToggleForDashboard(self::requireCommand($data));

        self::applyArgument($model, $data);
        self::applyArgumentType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgument(StatelessPowerToggleForDashboard $model, array $data): void
    {
        if (empty($data[self::KEY_ARGUMENT])) {
            return;
        }
        if (!is_string($data[self::KEY_ARGUMENT])) {
            return;
        }
        $model->setArgument($data[self::KEY_ARGUMENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgumentType(StatelessPowerToggleForDashboard $model, array $data): void
    {
        if (empty($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        $model->setArgumentType($data[self::KEY_ARGUMENT_TYPE]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCommand(array $data): ?string
    {
        if (empty($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            return null;
        }

        return $data[self::KEY_COMMAND];
    }
}
