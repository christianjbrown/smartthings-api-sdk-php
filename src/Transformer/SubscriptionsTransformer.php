<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SubscriptionInterface;

use function array_values;
use function count;
use function sprintf;

final class SubscriptionsTransformer implements SubscriptionsTransformerInterface
{
    private SubscriptionTransformerInterface $subscriptionTransformer;

    public function __construct(SubscriptionTransformerInterface $subscriptionTransformer)
    {
        $this->subscriptionTransformer = $subscriptionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SubscriptionInterface>
     */
    public function transform(array $data): array
    {
        $subscriptions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $subscriptionData = $values[$i];
            if (!is_array($subscriptionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $subscriptions[] = $this->subscriptionTransformer->transform($subscriptionData);
        }

        return $subscriptions;
    }
}
