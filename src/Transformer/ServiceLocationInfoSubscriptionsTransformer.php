<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscriptionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ServiceLocationInfoSubscriptionsTransformer implements ServiceLocationInfoSubscriptionsTransformerInterface
{
    private ServiceLocationInfoSubscriptionTransformerInterface $serviceLocationInfoSubscriptionTransformer;

    public function __construct(ServiceLocationInfoSubscriptionTransformerInterface $serviceLocationInfoSubscriptionTransformer)
    {
        $this->serviceLocationInfoSubscriptionTransformer = $serviceLocationInfoSubscriptionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ServiceLocationInfoSubscriptionInterface>
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
            $subscriptions[] = $this->serviceLocationInfoSubscriptionTransformer->transform($subscriptionData);
        }

        return $subscriptions;
    }
}
