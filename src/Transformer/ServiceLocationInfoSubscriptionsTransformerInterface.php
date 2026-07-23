<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscriptionInterface;

interface ServiceLocationInfoSubscriptionsTransformerInterface
{
    public const string ARRAY_NAME = 'subscription';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ServiceLocationInfoSubscriptionInterface>
     */
    public function transform(array $data): array;
}
