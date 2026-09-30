<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubHealthDetail;
use ChristianBrown\SmartThings\Model\HubHealthDetailInterface;

use function is_string;

final class HubHealthDetailTransformer implements HubHealthDetailTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubHealthDetailInterface
    {
        $model = new HubHealthDetail(self::requireLocationId($data));

        self::applySubscriptionName($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubscriptionName(HubHealthDetail $model, array $data): void
    {
        if (empty($data[self::KEY_SUBSCRIPTION_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_SUBSCRIPTION_NAME])) {
            return;
        }
        $model->setSubscriptionName($data[self::KEY_SUBSCRIPTION_NAME]);
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
