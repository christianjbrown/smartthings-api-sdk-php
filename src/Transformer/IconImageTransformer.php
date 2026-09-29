<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IconImage;
use ChristianBrown\SmartThings\Model\IconImageInterface;

use function is_string;

final class IconImageTransformer implements IconImageTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IconImageInterface
    {
        $model = new IconImage();

        self::applyUrl($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUrl(IconImage $model, array $data): void
    {
        if (empty($data[self::KEY_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_URL])) {
            return;
        }
        $model->setUrl($data[self::KEY_URL]);
    }
}
