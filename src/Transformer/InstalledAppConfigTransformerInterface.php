<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;

interface InstalledAppConfigTransformerInterface
{
    public const string KEY_CONFIGURATION_ID = 'configurationId';
    public const string KEY_CONFIGURATION_STATUS = 'configurationStatus';
    public const string KEY_INSTALLED_APP_ID = 'installedAppId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppConfigInterface;
}
