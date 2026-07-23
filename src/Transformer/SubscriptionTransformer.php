<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Subscription;
use ChristianBrown\SmartThings\Model\SubscriptionInterface;

use function is_string;
use function sprintf;

final class SubscriptionTransformer implements SubscriptionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SubscriptionInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $subscription = new Subscription($data[self::KEY_ID]);

        self::applyInstalledAppId($subscription, $data);
        self::applySourceType($subscription, $data);

        return $subscription;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstalledAppId(Subscription $subscription, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        $subscription->setInstalledAppId($data[self::KEY_INSTALLED_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySourceType(Subscription $subscription, array $data): void
    {
        if (empty($data[self::KEY_SOURCE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_SOURCE_TYPE])) {
            return;
        }
        $subscription->setSourceType($data[self::KEY_SOURCE_TYPE]);
    }
}
