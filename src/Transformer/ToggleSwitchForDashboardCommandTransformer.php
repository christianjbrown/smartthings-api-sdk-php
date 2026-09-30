<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommand;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;

use function is_string;

final class ToggleSwitchForDashboardCommandTransformer implements ToggleSwitchForDashboardCommandTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ToggleSwitchForDashboardCommandInterface
    {
        $model = new ToggleSwitchForDashboardCommand(self::requireOn($data), self::requireOff($data));

        self::applyName($model, $data);
        self::applyArgumentType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgumentType(ToggleSwitchForDashboardCommand $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private static function applyName(ToggleSwitchForDashboardCommand $model, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $model->setName($data[self::KEY_NAME]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOff(array $data): ?string
    {
        if (empty($data[self::KEY_OFF])) {
            return null;
        }
        if (!is_string($data[self::KEY_OFF])) {
            return null;
        }

        return $data[self::KEY_OFF];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOn(array $data): ?string
    {
        if (empty($data[self::KEY_ON])) {
            return null;
        }
        if (!is_string($data[self::KEY_ON])) {
            return null;
        }

        return $data[self::KEY_ON];
    }
}
