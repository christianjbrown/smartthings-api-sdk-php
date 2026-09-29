<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceSubscriptionDetailInterface;

interface DeviceSubscriptionDetailTransformerInterface
{
    public const string KEY_ATTRIBUTE = 'attribute';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT_ID = 'componentId';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_MODES = 'modes';
    public const string KEY_STATE_CHANGE_ONLY = 'stateChangeOnly';
    public const string KEY_SUBSCRIPTION_NAME = 'subscriptionName';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceSubscriptionDetailInterface;
}
