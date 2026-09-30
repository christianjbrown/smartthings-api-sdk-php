<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CommandArgument;
use ChristianBrown\SmartThings\Model\CommandArgumentInterface;

use function is_array;
use function is_bool;
use function is_string;

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
    private static function requireName(array $data): ?string
    {
        if (empty($data[self::KEY_NAME])) {
            return null;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return null;
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
            return [];
        }
        if (!is_array($data[self::KEY_SCHEMA])) {
            return [];
        }

        return $data[self::KEY_SCHEMA];
    }
}
