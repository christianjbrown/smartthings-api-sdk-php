<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;

interface DeviceConfigurationDpInfosItemSerializerInterface
{
    public const string KEY_DP_INFO = 'dpInfo';
    public const string KEY_ST_PLUGIN_API_VERSION = 'stPluginApiVersion';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationDpInfosItemInterface $model): array;
}
