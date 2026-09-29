<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LanDeviceDetailsInterface;

interface LanDeviceDetailsTransformerInterface
{
    public const string KEY_DRIVER_ID = 'driverId';
    public const string KEY_EXECUTING_LOCALLY = 'executingLocally';
    public const string KEY_FINGERPRINT_ID = 'fingerprintId';
    public const string KEY_FINGERPRINT_TYPE = 'fingerprintType';
    public const string KEY_HUB_ID = 'hubId';
    public const string KEY_NETWORK_ID = 'networkId';
    public const string KEY_PROVISIONING_STATE = 'provisioningState';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LanDeviceDetailsInterface;
}
