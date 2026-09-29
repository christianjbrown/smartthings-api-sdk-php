<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceLifecycleDetailInterface;

interface DeviceLifecycleDetailTransformerInterface
{
    public const string KEY_DEVICE_IDS = 'deviceIds';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_SUBSCRIPTION_NAME = 'subscriptionName';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceLifecycleDetailInterface;
}
