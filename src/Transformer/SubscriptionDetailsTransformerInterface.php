<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SubscriptionDetailsInterface;

interface SubscriptionDetailsTransformerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_DEVICE = 'device';
    public const string KEY_DEVICE_HEALTH = 'deviceHealth';
    public const string KEY_DEVICE_LIFECYCLE = 'deviceLifecycle';
    public const string KEY_HUB_HEALTH = 'hubHealth';
    public const string KEY_MODE = 'mode';
    public const string KEY_SCENE_LIFECYCLE = 'sceneLifecycle';
    public const string KEY_SECURITY_ARM_STATE = 'securityArmState';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SubscriptionDetailsInterface;
}
