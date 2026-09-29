<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MatterDeviceDetailsInterface;

interface MatterDeviceDetailsTransformerInterface
{
    public const string KEY_DRIVER_ID = 'driverId';
    public const string KEY_ENDPOINTS = 'endpoints';
    public const string KEY_EXECUTING_LOCALLY = 'executingLocally';
    public const string KEY_FINGERPRINT_ID = 'fingerprintId';
    public const string KEY_FINGERPRINT_TYPE = 'fingerprintType';
    public const string KEY_HUB_ID = 'hubId';
    public const string KEY_LISTENING_TYPE = 'listeningType';
    public const string KEY_NETWORK_ID = 'networkId';
    public const string KEY_PRODUCT_ID = 'productId';
    public const string KEY_PROVISIONING_STATE = 'provisioningState';
    public const string KEY_SERIAL_NUMBER = 'serialNumber';
    public const string KEY_SUPPORTED_NETWORK_INTERFACES = 'supportedNetworkInterfaces';
    public const string KEY_SYNC_DRIVERS = 'syncDrivers';
    public const string KEY_UNIQUE_ID = 'uniqueId';
    public const string KEY_VENDOR_ID = 'vendorId';
    public const string KEY_VERSION = 'version';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MatterDeviceDetailsInterface;
}
