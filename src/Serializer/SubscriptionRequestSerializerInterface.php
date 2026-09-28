<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SubscriptionRequestInterface;

interface SubscriptionRequestSerializerInterface
{
    public const string KEY_ATTRIBUTE = 'attribute';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT_ID = 'componentId';
    public const string KEY_DEVICE = 'device';
    public const string KEY_DEVICE_HEALTH = 'deviceHealth';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_DEVICE_IDS = 'deviceIds';
    public const string KEY_DEVICE_LIFECYCLE = 'deviceLifecycle';
    public const string KEY_HUB_HEALTH = 'hubHealth';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_MODE = 'mode';
    public const string KEY_MODES = 'modes';
    public const string KEY_SCENE_LIFECYCLE = 'sceneLifecycle';
    public const string KEY_SECURITY_ARM_STATE = 'securityArmState';
    public const string KEY_SOURCE_TYPE = 'sourceType';
    public const string KEY_STATE_CHANGE_ONLY = 'stateChangeOnly';
    public const string KEY_SUBSCRIPTION_NAME = 'subscriptionName';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(SubscriptionRequestInterface $request): array;
}
