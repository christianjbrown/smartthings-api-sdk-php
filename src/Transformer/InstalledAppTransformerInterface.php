<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppInterface;

interface InstalledAppTransformerInterface
{
    public const string KEY_APP_ID = 'appId';
    public const string KEY_DISPLAY_NAME = 'displayName';
    public const string KEY_INSTALLED_APP_ID = 'installedAppId';
    public const string KEY_INSTALLED_APP_STATUS = 'installedAppStatus';
    public const string KEY_INSTALLED_APP_TYPE = 'installedAppType';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppInterface;
}
