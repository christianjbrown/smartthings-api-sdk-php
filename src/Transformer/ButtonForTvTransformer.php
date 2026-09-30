<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ButtonForTv;
use ChristianBrown\SmartThings\Model\ButtonForTvInterface;

use function is_int;
use function is_string;

final class ButtonForTvTransformer implements ButtonForTvTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ButtonForTvInterface
    {
        $model = new ButtonForTv(self::requireCapability($data), self::requireComponent($data), self::requireCommand($data));

        self::applyVersion($model, $data);
        self::applyArgument($model, $data);
        self::applyIconUrl($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgument(ButtonForTv $model, array $data): void
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
    private static function applyIconUrl(ButtonForTv $model, array $data): void
    {
        if (empty($data[self::KEY_ICON_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ICON_URL])) {
            return;
        }
        $model->setIconUrl($data[self::KEY_ICON_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(ButtonForTv $model, array $data): void
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
}
