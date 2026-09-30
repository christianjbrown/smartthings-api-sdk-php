<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PatchItem;
use ChristianBrown\SmartThings\Model\PatchItemInterface;

use function is_array;
use function is_string;

final class PatchItemTransformer implements PatchItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PatchItemInterface
    {
        $model = new PatchItem(self::requireOp($data), self::requirePath($data));

        self::applyValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(PatchItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOp(array $data): ?string
    {
        if (empty($data[self::KEY_OP])) {
            return null;
        }
        if (!is_string($data[self::KEY_OP])) {
            return null;
        }

        return $data[self::KEY_OP];
    }

    /**
     * @param mixed[] $data
     */
    private static function requirePath(array $data): ?string
    {
        if (empty($data[self::KEY_PATH])) {
            return null;
        }
        if (!is_string($data[self::KEY_PATH])) {
            return null;
        }

        return $data[self::KEY_PATH];
    }
}
