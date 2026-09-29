<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixInterface;

interface HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface
{
    public const string KEY_CAPABILITIES = 'capabilities';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDeviceDetailsHubDataHub2hubSupportMatrixInterface;
}
