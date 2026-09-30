<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigInterface;

interface DeviceConfigTransformerInterface
{
    public const string KEY_COMPONENT_ID = 'componentId';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_PERMISSIONS = 'permissions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigInterface;
}
