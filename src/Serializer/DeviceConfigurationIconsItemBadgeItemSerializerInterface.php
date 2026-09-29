<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItemInterface;

interface DeviceConfigurationIconsItemBadgeItemSerializerInterface
{
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationIconsItemBadgeItemInterface $model): array;
}
