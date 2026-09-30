<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\VisibleConditionForDashboardState;
use ChristianBrown\SmartThings\Model\VisibleConditionForDashboardStateInterface;

use function is_bool;
use function is_int;
use function is_string;

final class VisibleConditionForDashboardStateTransformer implements VisibleConditionForDashboardStateTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VisibleConditionForDashboardStateInterface
    {
        $model = new VisibleConditionForDashboardState(self::requireValue($data), self::requireOperator($data), self::requireOperand($data), self::requireComponent($data), self::requireCapability($data));

        self::applyValueType($model, $data);
        self::applyVersion($model, $data);
        self::applyIsOffline($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIsOffline(VisibleConditionForDashboardState $model, array $data): void
    {
        if (!isset($data[self::KEY_IS_OFFLINE])) {
            return;
        }
        if (!is_bool($data[self::KEY_IS_OFFLINE])) {
            return;
        }
        $model->setIsOffline($data[self::KEY_IS_OFFLINE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(VisibleConditionForDashboardState $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        $model->setValueType($data[self::KEY_VALUE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(VisibleConditionForDashboardState $model, array $data): void
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
    private static function requireComponent(array $data): ?string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return null;
        }

        return $data[self::KEY_COMPONENT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOperand(array $data): ?string
    {
        if (empty($data[self::KEY_OPERAND])) {
            return null;
        }
        if (!is_string($data[self::KEY_OPERAND])) {
            return null;
        }

        return $data[self::KEY_OPERAND];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOperator(array $data): ?string
    {
        if (empty($data[self::KEY_OPERATOR])) {
            return null;
        }
        if (!is_string($data[self::KEY_OPERATOR])) {
            return null;
        }

        return $data[self::KEY_OPERATOR];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): ?string
    {
        if (empty($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return null;
        }

        return $data[self::KEY_VALUE];
    }
}
