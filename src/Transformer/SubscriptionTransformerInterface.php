<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SubscriptionInterface;

interface SubscriptionTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_DEVICE, self::KEY_CAPABILITY, self::KEY_MODE, self::KEY_DEVICE_LIFECYCLE, self::KEY_DEVICE_HEALTH, self::KEY_SECURITY_ARM_STATE, self::KEY_HUB_HEALTH, self::KEY_SCENE_LIFECYCLE];
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_DEVICE = 'device';
    public const string KEY_DEVICE_HEALTH = 'deviceHealth';
    public const string KEY_DEVICE_LIFECYCLE = 'deviceLifecycle';
    public const string KEY_HUB_HEALTH = 'hubHealth';
    public const string KEY_ID = 'id';
    public const string KEY_INSTALLED_APP_ID = 'installedAppId';
    public const string KEY_MODE = 'mode';
    public const string KEY_SCENE_LIFECYCLE = 'sceneLifecycle';
    public const string KEY_SECURITY_ARM_STATE = 'securityArmState';
    public const string KEY_SOURCE_TYPE = 'sourceType';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SubscriptionInterface;
}
