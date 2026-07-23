<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscriptionInterface;

interface ServiceLocationInfoSubscriptionTransformerInterface
{
    public const string KEY_PREDICATE = 'predicate';
    public const string KEY_SUBSCRIBED_CAPABILITIES = 'subscribedCapabilities';
    public const string KEY_SUBSCRIPTION_ID = 'subscriptionId';
    public const string KEY_TYPE = 'type';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceLocationInfoSubscriptionInterface;
}
