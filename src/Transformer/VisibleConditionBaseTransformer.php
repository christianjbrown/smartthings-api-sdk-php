<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\VisibleConditionBase;
use ChristianBrown\SmartThings\Model\VisibleConditionBaseInterface;

use function is_string;

final class VisibleConditionBaseTransformer implements VisibleConditionBaseTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VisibleConditionBaseInterface
    {
        $model = new VisibleConditionBase(self::requireValue($data), self::requireOperator($data), self::requireOperand($data));

        self::applyValueType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(VisibleConditionBase $model, array $data): void
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
