<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ZWaveManufacturerFingerprint;
use ChristianBrown\SmartThings\Model\ZWaveManufacturerFingerprintInterface;

use function is_array;
use function is_int;
use function sprintf;

final class ZWaveManufacturerFingerprintTransformer implements ZWaveManufacturerFingerprintTransformerInterface
{
    private DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer;

    public function __construct(DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer)
    {
        $this->deviceIntegrationProfileKeyTransformer = $deviceIntegrationProfileKeyTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZWaveManufacturerFingerprintInterface
    {
        $model = new ZWaveManufacturerFingerprint(self::requireProductType($data));

        self::applyManufacturerId($model, $data);
        self::applyProductId($model, $data);
        $this->applyDeviceIntegrationProfileKey($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeviceIntegrationProfileKey(ZWaveManufacturerFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_INTEGRATION_PROFILE_KEY])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_INTEGRATION_PROFILE_KEY])) {
            return;
        }
        $model->setDeviceIntegrationProfileKey($this->deviceIntegrationProfileKeyTransformer->transform($data[self::KEY_DEVICE_INTEGRATION_PROFILE_KEY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyManufacturerId(ZWaveManufacturerFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_MANUFACTURER_ID])) {
            return;
        }
        if (!is_int($data[self::KEY_MANUFACTURER_ID])) {
            return;
        }
        $model->setManufacturerId($data[self::KEY_MANUFACTURER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProductId(ZWaveManufacturerFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_PRODUCT_ID])) {
            return;
        }
        if (!is_int($data[self::KEY_PRODUCT_ID])) {
            return;
        }
        $model->setProductId($data[self::KEY_PRODUCT_ID]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireProductType(array $data): int
    {
        if (!isset($data[self::KEY_PRODUCT_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_INT_SPRINTF, self::KEY_PRODUCT_TYPE));
        }
        if (!is_int($data[self::KEY_PRODUCT_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_INT_SPRINTF, self::KEY_PRODUCT_TYPE));
        }

        return $data[self::KEY_PRODUCT_TYPE];
    }
}
