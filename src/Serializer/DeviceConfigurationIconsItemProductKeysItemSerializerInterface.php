<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItemInterface;

interface DeviceConfigurationIconsItemProductKeysItemSerializerInterface
{
    public const string KEY_MN_ID = 'mnId';
    public const string KEY_SETUP_ID = 'setupId';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationIconsItemProductKeysItemInterface $model): array;
}
