<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceSubscriptionReceipt;
use ChristianBrown\SmartThings\Model\ServiceSubscriptionReceiptInterface;

use function is_string;

final class ServiceSubscriptionReceiptTransformer implements ServiceSubscriptionReceiptTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceSubscriptionReceiptInterface
    {
        $model = new ServiceSubscriptionReceipt(self::requireLocationId($data));

        self::applySubscriptionId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubscriptionId(ServiceSubscriptionReceipt $model, array $data): void
    {
        if (empty($data[self::KEY_SUBSCRIPTION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_SUBSCRIPTION_ID])) {
            return;
        }
        $model->setSubscriptionId($data[self::KEY_SUBSCRIPTION_ID]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLocationId(array $data): ?string
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return null;
        }

        return $data[self::KEY_LOCATION_ID];
    }
}
