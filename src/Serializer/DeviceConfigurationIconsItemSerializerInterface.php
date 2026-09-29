<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;

interface DeviceConfigurationIconsItemSerializerInterface
{
    public const string KEY_BADGE = 'badge';
    public const string KEY_GROUP = 'group';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_PRODUCT_KEYS = 'productKeys';
    public const string KEY_RUNNING_CONDITIONS = 'runningConditions';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationIconsItemInterface $model): array;
}
