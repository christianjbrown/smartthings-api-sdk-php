<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CommandClasses;
use ChristianBrown\SmartThings\Model\CommandClassesInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_int;

final class CommandClassesTransformer implements CommandClassesTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandClassesInterface
    {
        $model = new CommandClasses();

        self::applyEither($model, $data);
        self::applyControlled($model, $data);
        self::applySupported($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyControlled(CommandClasses $model, array $data): void
    {
        if (!isset($data[self::KEY_CONTROLLED])) {
            return;
        }
        if (!is_array($data[self::KEY_CONTROLLED])) {
            return;
        }
        $model->setControlled(array_values(array_filter($data[self::KEY_CONTROLLED], is_int(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEither(CommandClasses $model, array $data): void
    {
        if (!isset($data[self::KEY_EITHER])) {
            return;
        }
        if (!is_array($data[self::KEY_EITHER])) {
            return;
        }
        $model->setEither(array_values(array_filter($data[self::KEY_EITHER], is_int(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupported(CommandClasses $model, array $data): void
    {
        if (!isset($data[self::KEY_SUPPORTED])) {
            return;
        }
        if (!is_array($data[self::KEY_SUPPORTED])) {
            return;
        }
        $model->setSupported(array_values(array_filter($data[self::KEY_SUPPORTED], is_int(...))));
    }
}
