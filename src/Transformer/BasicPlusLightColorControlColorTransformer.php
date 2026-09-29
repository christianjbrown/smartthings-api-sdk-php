<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColor;
use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColorInterface;

use function is_string;

final class BasicPlusLightColorControlColorTransformer implements BasicPlusLightColorControlColorTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusLightColorControlColorInterface
    {
        $model = new BasicPlusLightColorControlColor();

        self::applyHue($model, $data);
        self::applySaturation($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHue(BasicPlusLightColorControlColor $model, array $data): void
    {
        if (empty($data[self::KEY_HUE])) {
            return;
        }
        if (!is_string($data[self::KEY_HUE])) {
            return;
        }
        $model->setHue($data[self::KEY_HUE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySaturation(BasicPlusLightColorControlColor $model, array $data): void
    {
        if (empty($data[self::KEY_SATURATION])) {
            return;
        }
        if (!is_string($data[self::KEY_SATURATION])) {
            return;
        }
        $model->setSaturation($data[self::KEY_SATURATION]);
    }
}
