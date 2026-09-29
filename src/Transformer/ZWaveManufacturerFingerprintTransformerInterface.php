<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ZWaveManufacturerFingerprintInterface;

interface ZWaveManufacturerFingerprintTransformerInterface
{
    public const string KEY_DEVICE_INTEGRATION_PROFILE_KEY = 'deviceIntegrationProfileKey';
    public const string KEY_MANUFACTURER_ID = 'manufacturerId';
    public const string KEY_PRODUCT_ID = 'productId';
    public const string KEY_PRODUCT_TYPE = 'productType';
    public const string UNEXPECTED_INT_SPRINTF = '%s not set or not an integer';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZWaveManufacturerFingerprintInterface;
}
