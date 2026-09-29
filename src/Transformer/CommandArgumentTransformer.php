<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CommandArgument;
use ChristianBrown\SmartThings\Model\CommandArgumentInterface;

use function is_array;
use function is_bool;
use function is_string;
use function sprintf;

final class CommandArgumentTransformer implements CommandArgumentTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandArgumentInterface
    {
        $model = new CommandArgument(self::requireName($data), self::requireSchema($data));

        self::applyOptional($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOptional(CommandArgument $model, array $data): void
    {
        if (!isset($data[self::KEY_OPTIONAL])) {
            return;
        }
        if (!is_bool($data[self::KEY_OPTIONAL])) {
            return;
        }
        $model->setOptional($data[self::KEY_OPTIONAL]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireName(array $data): string
    {
        if (empty($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (!is_string($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }

        return $data[self::KEY_NAME];
    }

    /**
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    private static function requireSchema(array $data): array
    {
        if (!isset($data[self::KEY_SCHEMA])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_SCHEMA));
        }
        if (!is_array($data[self::KEY_SCHEMA])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_SCHEMA));
        }

        return $data[self::KEY_SCHEMA];
    }
}
