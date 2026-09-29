<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppDeviceDetailsInterface;

interface AppDeviceDetailsTransformerInterface
{
    public const string KEY_EXTERNAL_ID = 'externalId';
    public const string KEY_INSTALLED_APP_ID = 'installedAppId';
    public const string KEY_PROFILE = 'profile';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppDeviceDetailsInterface;
}
