<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;

interface DeviceConfigurationDpInfosItemTransformerInterface
{
    public const string KEY_DP_INFO = 'dpInfo';
    public const string KEY_ST_PLUGIN_API_VERSION = 'stPluginApiVersion';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationDpInfosItemInterface;
}
