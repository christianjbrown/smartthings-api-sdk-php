<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PushButtonForPanelItem;
use ChristianBrown\SmartThings\Model\PushButtonForPanelItemInterface;

use function is_string;

final class PushButtonForPanelItemTransformer implements PushButtonForPanelItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PushButtonForPanelItemInterface
    {
        $model = new PushButtonForPanelItem(self::requireCommand($data), self::requireSize($data));

        self::applyArgument($model, $data);
        self::applyArgumentType($model, $data);
        self::applyIconUrl($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgument(PushButtonForPanelItem $model, array $data): void
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
    private static function applyArgumentType(PushButtonForPanelItem $model, array $data): void
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
    private static function applyIconUrl(PushButtonForPanelItem $model, array $data): void
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
    private static function requireSize(array $data): ?string
    {
        if (empty($data[self::KEY_SIZE])) {
            return null;
        }
        if (!is_string($data[self::KEY_SIZE])) {
            return null;
        }

        return $data[self::KEY_SIZE];
    }
}
