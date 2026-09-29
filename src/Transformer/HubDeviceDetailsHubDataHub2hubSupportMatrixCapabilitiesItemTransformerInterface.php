<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface;

interface HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface
{
    public const string KEY_NAME = 'name';
    public const string KEY_VERSION = 'version';
    public const string UNEXPECTED_INT_SPRINTF = '%s not set or not an integer';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface;
}
