<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestInterface;

interface DeviceConfigurationRequestSerializerInterface
{
    public const string KEY_AUTOMATION = 'automation';
    public const string KEY_DASHBOARD = 'dashboard';
    public const string KEY_DETAIL_VIEW = 'detailView';
    public const string KEY_DEVICE_PROFILE_ID = 'deviceProfileId';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_ICONS = 'icons';
    public const string KEY_TYPE = 'type';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationRequestInterface $model): array;
}
