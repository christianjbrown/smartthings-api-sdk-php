<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\HubDeviceUpdateRequestInterface;

interface HubDeviceUpdateRequestSerializerInterface
{
    public const string KEY_DEVICE_INTEGRATION_PROFILE_KEY = 'deviceIntegrationProfileKey';
    public const string KEY_DRIVER_ID = 'driverId';
    public const string KEY_ID = 'id';
    public const string KEY_MAJOR_VERSION = 'majorVersion';
    public const string KEY_PROVISIONING_STATE = 'provisioningState';

    /**
     * @return mixed[]
     */
    public function serialize(HubDeviceUpdateRequestInterface $request): array;
}
