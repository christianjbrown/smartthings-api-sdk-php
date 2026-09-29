<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BleD2DDeviceDetailsInterface;

interface BleD2DDeviceDetailsTransformerInterface
{
    public const string KEY_ADVERTISING_ID = 'advertisingId';
    public const string KEY_BLE_DEVICE_TYPE = 'bleDeviceType';
    public const string KEY_CIPHER = 'cipher';
    public const string KEY_CONFIGURATION_URL = 'configurationUrl';
    public const string KEY_CONFIGURATION_VERSION = 'configurationVersion';
    public const string KEY_ENCRYPTION_KEY = 'encryptionKey';
    public const string KEY_GATT_CIPHER = 'gattCipher';
    public const string KEY_IDENTIFIER = 'identifier';
    public const string KEY_METADATA = 'metadata';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BleD2DDeviceDetailsInterface;
}
