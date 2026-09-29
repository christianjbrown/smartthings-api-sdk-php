<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ZigbeeManufacturerFingerprintInterface;

interface ZigbeeManufacturerFingerprintTransformerInterface
{
    public const string KEY_DEVICE_INTEGRATION_PROFILE_KEY = 'deviceIntegrationProfileKey';
    public const string KEY_MANUFACTURER = 'manufacturer';
    public const string KEY_MODEL = 'model';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZigbeeManufacturerFingerprintInterface;
}
