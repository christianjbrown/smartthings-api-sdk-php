<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LambdaSmartApp;
use ChristianBrown\SmartThings\Model\LambdaSmartAppInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

final class LambdaSmartAppTransformer implements LambdaSmartAppTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LambdaSmartAppInterface
    {
        $model = new LambdaSmartApp();

        self::applyFunctions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFunctions(LambdaSmartApp $model, array $data): void
    {
        if (!isset($data[self::KEY_FUNCTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_FUNCTIONS])) {
            return;
        }
        $model->setFunctions(array_values(array_filter($data[self::KEY_FUNCTIONS], is_string(...))));
    }
}
