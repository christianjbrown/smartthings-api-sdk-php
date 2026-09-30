<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommand;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommandInterface;

use function is_string;

final class BasicPlusTvDirectionalPadCommandTransformer implements BasicPlusTvDirectionalPadCommandTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvDirectionalPadCommandInterface
    {
        $model = new BasicPlusTvDirectionalPadCommand(self::requireUp($data), self::requireDown($data), self::requireLeft($data), self::requireRight($data), self::requireOk($data));

        self::applyName($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(BasicPlusTvDirectionalPadCommand $model, array $data): void
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
    private static function requireDown(array $data): ?string
    {
        if (empty($data[self::KEY_DOWN])) {
            return null;
        }
        if (!is_string($data[self::KEY_DOWN])) {
            return null;
        }

        return $data[self::KEY_DOWN];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLeft(array $data): ?string
    {
        if (empty($data[self::KEY_LEFT])) {
            return null;
        }
        if (!is_string($data[self::KEY_LEFT])) {
            return null;
        }

        return $data[self::KEY_LEFT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOk(array $data): ?string
    {
        if (empty($data[self::KEY_OK])) {
            return null;
        }
        if (!is_string($data[self::KEY_OK])) {
            return null;
        }

        return $data[self::KEY_OK];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireRight(array $data): ?string
    {
        if (empty($data[self::KEY_RIGHT])) {
            return null;
        }
        if (!is_string($data[self::KEY_RIGHT])) {
            return null;
        }

        return $data[self::KEY_RIGHT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireUp(array $data): ?string
    {
        if (empty($data[self::KEY_UP])) {
            return null;
        }
        if (!is_string($data[self::KEY_UP])) {
            return null;
        }

        return $data[self::KEY_UP];
    }
}
