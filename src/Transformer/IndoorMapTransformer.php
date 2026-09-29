<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IndoorMap;
use ChristianBrown\SmartThings\Model\IndoorMapInterface;

use function is_array;
use function is_bool;

final class IndoorMapTransformer implements IndoorMapTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IndoorMapInterface
    {
        $model = new IndoorMap();

        self::applyCoordinates($model, $data);
        self::applyRotation($model, $data);
        self::applyVisible($model, $data);
        self::applyData($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCoordinates(IndoorMap $model, array $data): void
    {
        if (!isset($data[self::KEY_COORDINATES])) {
            return;
        }
        if (!is_array($data[self::KEY_COORDINATES])) {
            return;
        }
        $model->setCoordinates($data[self::KEY_COORDINATES]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyData(IndoorMap $model, array $data): void
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
    private static function applyRotation(IndoorMap $model, array $data): void
    {
        if (!isset($data[self::KEY_ROTATION])) {
            return;
        }
        if (!is_array($data[self::KEY_ROTATION])) {
            return;
        }
        $model->setRotation($data[self::KEY_ROTATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVisible(IndoorMap $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE])) {
            return;
        }
        if (!is_bool($data[self::KEY_VISIBLE])) {
            return;
        }
        $model->setVisible($data[self::KEY_VISIBLE]);
    }
}
