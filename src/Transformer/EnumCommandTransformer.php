<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\EnumCommand;
use ChristianBrown\SmartThings\Model\EnumCommandInterface;

use function is_string;

final class EnumCommandTransformer implements EnumCommandTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EnumCommandInterface
    {
        $model = new EnumCommand(self::requireCommand($data), self::requireValue($data));

        return $model;
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
