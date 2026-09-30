<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PlayPauseCommand;
use ChristianBrown\SmartThings\Model\PlayPauseCommandInterface;

use function is_string;

final class PlayPauseCommandTransformer implements PlayPauseCommandTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PlayPauseCommandInterface
    {
        $model = new PlayPauseCommand(self::requirePlay($data), self::requirePause($data));

        self::applyName($model, $data);
        self::applyArgumentType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgumentType(PlayPauseCommand $model, array $data): void
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
    private static function applyName(PlayPauseCommand $model, array $data): void
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
    private static function requirePause(array $data): ?string
    {
        if (empty($data[self::KEY_PAUSE])) {
            return null;
        }
        if (!is_string($data[self::KEY_PAUSE])) {
            return null;
        }

        return $data[self::KEY_PAUSE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requirePlay(array $data): ?string
    {
        if (empty($data[self::KEY_PLAY])) {
            return null;
        }
        if (!is_string($data[self::KEY_PLAY])) {
            return null;
        }

        return $data[self::KEY_PLAY];
    }
}
