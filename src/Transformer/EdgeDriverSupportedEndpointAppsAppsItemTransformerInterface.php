<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsAppsItemInterface;

interface EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface
{
    public const string KEY_APP_NAME = 'appName';
    public const string KEY_VERSION = 'version';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EdgeDriverSupportedEndpointAppsAppsItemInterface;
}
