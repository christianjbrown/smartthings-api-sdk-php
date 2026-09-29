<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SecurityArmStateDetail;
use ChristianBrown\SmartThings\Model\SecurityArmStateDetailInterface;

use function is_string;
use function sprintf;

final class SecurityArmStateDetailTransformer implements SecurityArmStateDetailTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SecurityArmStateDetailInterface
    {
        $model = new SecurityArmStateDetail(self::requireLocationId($data));

        self::applySubscriptionName($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubscriptionName(SecurityArmStateDetail $model, array $data): void
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
    private static function requireLocationId(array $data): string
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }

        return $data[self::KEY_LOCATION_ID];
    }
}
