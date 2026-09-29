<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\EmptyWithAvailableSize;
use ChristianBrown\SmartThings\Model\EmptyWithAvailableSizeInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

final class EmptyWithAvailableSizeTransformer implements EmptyWithAvailableSizeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EmptyWithAvailableSizeInterface
    {
        $model = new EmptyWithAvailableSize();

        self::applyAvailableSizes($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAvailableSizes(EmptyWithAvailableSize $model, array $data): void
    {
        if (!isset($data[self::KEY_AVAILABLE_SIZES])) {
            return;
        }
        if (!is_array($data[self::KEY_AVAILABLE_SIZES])) {
            return;
        }
        $model->setAvailableSizes(array_values(array_filter($data[self::KEY_AVAILABLE_SIZES], is_string(...))));
    }
}
