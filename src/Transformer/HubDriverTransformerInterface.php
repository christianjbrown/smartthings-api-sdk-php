<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubDriverInterface;

interface HubDriverTransformerInterface
{
    public const string KEY_CHANNEL_ID = 'channelId';
    public const string KEY_DRIVER_ID = 'driverId';
    public const string KEY_DRIVER_VERSION = 'driverVersion';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDriverInterface;
}
