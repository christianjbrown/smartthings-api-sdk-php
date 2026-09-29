<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;

interface DeviceConfigurationDpInfoItemSerializerInterface
{
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_DP_URI = 'dpUri';
    public const string KEY_OPERATING_MODE = 'operatingMode';
    public const string KEY_OS = 'os';
    public const string KEY_SERVER_DP_URI = 'serverDpUri';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationDpInfoItemInterface $model): array;
}
