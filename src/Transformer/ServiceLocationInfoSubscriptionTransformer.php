<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscription;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscriptionInterface;

use function array_values;
use function count;
use function is_array;
use function is_string;
use function sprintf;

final class ServiceLocationInfoSubscriptionTransformer implements ServiceLocationInfoSubscriptionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceLocationInfoSubscriptionInterface
    {
        if (empty($data[self::KEY_SUBSCRIPTION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_SUBSCRIPTION_ID));
        }
        if (!is_string($data[self::KEY_SUBSCRIPTION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_SUBSCRIPTION_ID));
        }
        $subscription = new ServiceLocationInfoSubscription($data[self::KEY_SUBSCRIPTION_ID]);

        self::applyPredicate($subscription, $data);
        self::applySubscribedCapabilities($subscription, $data);
        self::applyType($subscription, $data);

        return $subscription;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPredicate(ServiceLocationInfoSubscription $subscription, array $data): void
    {
        if (empty($data[self::KEY_PREDICATE])) {
            return;
        }
        if (!is_string($data[self::KEY_PREDICATE])) {
            return;
        }
        $subscription->setPredicate($data[self::KEY_PREDICATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubscribedCapabilities(ServiceLocationInfoSubscription $subscription, array $data): void
    {
        // An empty list is a valid result, so guard with isset/is_array rather
        // than empty() — that also keeps the loop's zero-iteration path reachable.
        if (!isset($data[self::KEY_SUBSCRIBED_CAPABILITIES])) {
            return;
        }
        if (!is_array($data[self::KEY_SUBSCRIBED_CAPABILITIES])) {
            return;
        }
        $capabilities = [];
        $values = array_values($data[self::KEY_SUBSCRIBED_CAPABILITIES]);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            if (is_string($values[$i])) {
                $capabilities[] = $values[$i];
            }
        }
        $subscription->setSubscribedCapabilities($capabilities);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(ServiceLocationInfoSubscription $subscription, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $subscription->setType($data[self::KEY_TYPE]);
    }
}
