<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceInstallRequestInterface;

interface DeviceInstallRequestSerializerInterface
{
    public const string KEY_APP = 'app';
    public const string KEY_EXTERNAL_ID = 'externalId';
    public const string KEY_INSTALLED_APP_ID = 'installedAppId';
    public const string KEY_LABEL = 'label';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_PROFILE_ID = 'profileId';
    public const string KEY_ROOM_ID = 'roomId';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceInstallRequestInterface $request): array;
}
