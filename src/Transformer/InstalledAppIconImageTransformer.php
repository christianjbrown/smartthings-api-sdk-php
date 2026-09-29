<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppIconImage;
use ChristianBrown\SmartThings\Model\InstalledAppIconImageInterface;

use function is_string;

final class InstalledAppIconImageTransformer implements InstalledAppIconImageTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppIconImageInterface
    {
        $model = new InstalledAppIconImage();

        self::applyUrl($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUrl(InstalledAppIconImage $model, array $data): void
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
