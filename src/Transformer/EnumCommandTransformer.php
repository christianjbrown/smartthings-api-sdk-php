<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EnumCommand;
use ChristianBrown\SmartThings\Model\EnumCommandInterface;

use function is_string;
use function sprintf;

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
    private static function requireCommand(array $data): string
    {
        if (empty($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMMAND));
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMMAND));
        }

        return $data[self::KEY_COMMAND];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): string
    {
        if (empty($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }
        if (!is_string($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }

        return $data[self::KEY_VALUE];
    }
}
