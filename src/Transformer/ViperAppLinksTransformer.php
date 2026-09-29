<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ViperAppLinks;
use ChristianBrown\SmartThings\Model\ViperAppLinksInterface;

use function is_bool;
use function is_string;

final class ViperAppLinksTransformer implements ViperAppLinksTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ViperAppLinksInterface
    {
        $model = new ViperAppLinks();

        self::applyAndroid($model, $data);
        self::applyIos($model, $data);
        self::applyIsLinkingEnabled($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAndroid(ViperAppLinks $model, array $data): void
    {
        if (empty($data[self::KEY_ANDROID])) {
            return;
        }
        if (!is_string($data[self::KEY_ANDROID])) {
            return;
        }
        $model->setAndroid($data[self::KEY_ANDROID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIos(ViperAppLinks $model, array $data): void
    {
        if (empty($data[self::KEY_IOS])) {
            return;
        }
        if (!is_string($data[self::KEY_IOS])) {
            return;
        }
        $model->setIos($data[self::KEY_IOS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIsLinkingEnabled(ViperAppLinks $model, array $data): void
    {
        if (!isset($data[self::KEY_IS_LINKING_ENABLED])) {
            return;
        }
        if (!is_bool($data[self::KEY_IS_LINKING_ENABLED])) {
            return;
        }
        $model->setIsLinkingEnabled($data[self::KEY_IS_LINKING_ENABLED]);
    }
}
