<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PlayStopCommand;
use ChristianBrown\SmartThings\Model\PlayStopCommandInterface;

use function is_string;
use function sprintf;

final class PlayStopCommandTransformer implements PlayStopCommandTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PlayStopCommandInterface
    {
        $model = new PlayStopCommand(self::requirePlay($data), self::requireStop($data));

        self::applyName($model, $data);
        self::applyArgumentType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgumentType(PlayStopCommand $model, array $data): void
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
    private static function applyName(PlayStopCommand $model, array $data): void
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
    private static function requirePlay(array $data): string
    {
        if (empty($data[self::KEY_PLAY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PLAY));
        }
        if (!is_string($data[self::KEY_PLAY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PLAY));
        }

        return $data[self::KEY_PLAY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireStop(array $data): string
    {
        if (empty($data[self::KEY_STOP])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_STOP));
        }
        if (!is_string($data[self::KEY_STOP])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_STOP));
        }

        return $data[self::KEY_STOP];
    }
}
