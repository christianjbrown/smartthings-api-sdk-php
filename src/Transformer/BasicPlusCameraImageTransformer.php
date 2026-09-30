<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraImage;
use ChristianBrown\SmartThings\Model\BasicPlusCameraImageInterface;

use function is_int;
use function is_string;

final class BasicPlusCameraImageTransformer implements BasicPlusCameraImageTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusCameraImageInterface
    {
        $model = new BasicPlusCameraImage(self::requireCapability($data), self::requireComponent($data), self::requireValue($data));

        self::applyVersion($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(BasicPlusCameraImage $model, array $data): void
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
