<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\WebhookSmartApp;
use ChristianBrown\SmartThings\Model\WebhookSmartAppInterface;

use function is_string;

final class WebhookSmartAppTransformer implements WebhookSmartAppTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): WebhookSmartAppInterface
    {
        $model = new WebhookSmartApp();

        self::applyTargetUrl($model, $data);
        self::applyTargetStatus($model, $data);
        self::applyPublicKey($model, $data);
        self::applySignatureType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPublicKey(WebhookSmartApp $model, array $data): void
    {
        if (empty($data[self::KEY_PUBLIC_KEY])) {
            return;
        }
        if (!is_string($data[self::KEY_PUBLIC_KEY])) {
            return;
        }
        $model->setPublicKey($data[self::KEY_PUBLIC_KEY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySignatureType(WebhookSmartApp $model, array $data): void
    {
        if (empty($data[self::KEY_SIGNATURE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_SIGNATURE_TYPE])) {
            return;
        }
        $model->setSignatureType($data[self::KEY_SIGNATURE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTargetStatus(WebhookSmartApp $model, array $data): void
    {
        if (empty($data[self::KEY_TARGET_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_TARGET_STATUS])) {
            return;
        }
        $model->setTargetStatus($data[self::KEY_TARGET_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTargetUrl(WebhookSmartApp $model, array $data): void
    {
        if (empty($data[self::KEY_TARGET_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_TARGET_URL])) {
            return;
        }
        $model->setTargetUrl($data[self::KEY_TARGET_URL]);
    }
}
