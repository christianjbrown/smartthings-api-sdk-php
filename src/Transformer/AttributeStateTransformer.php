<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeState;
use ChristianBrown\SmartThings\Model\AttributeStateInterface;

use function is_array;
use function is_string;

final class AttributeStateTransformer implements AttributeStateTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeStateInterface
    {
        $model = new AttributeState();

        self::applyValue($model, $data);
        self::applyUnit($model, $data);
        self::applyData($model, $data);
        self::applyTimestamp($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyData(AttributeState $model, array $data): void
    {
        if (!isset($data[self::KEY_DATA])) {
            return;
        }
        if (!is_array($data[self::KEY_DATA])) {
            return;
        }
        $model->setData($data[self::KEY_DATA]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTimestamp(AttributeState $model, array $data): void
    {
        if (empty($data[self::KEY_TIMESTAMP])) {
            return;
        }
        if (!is_string($data[self::KEY_TIMESTAMP])) {
            return;
        }
        $model->setTimestamp($data[self::KEY_TIMESTAMP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnit(AttributeState $model, array $data): void
    {
        if (empty($data[self::KEY_UNIT])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIT])) {
            return;
        }
        $model->setUnit($data[self::KEY_UNIT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(AttributeState $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }
}
