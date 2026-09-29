<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ZigbeeManufacturerFingerprint;
use ChristianBrown\SmartThings\Model\ZigbeeManufacturerFingerprintInterface;

use function is_array;
use function is_string;

final class ZigbeeManufacturerFingerprintTransformer implements ZigbeeManufacturerFingerprintTransformerInterface
{
    private DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer;

    public function __construct(DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer)
    {
        $this->deviceIntegrationProfileKeyTransformer = $deviceIntegrationProfileKeyTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZigbeeManufacturerFingerprintInterface
    {
        $model = new ZigbeeManufacturerFingerprint();

        self::applyManufacturer($model, $data);
        self::applyModel($model, $data);
        $this->applyDeviceIntegrationProfileKey($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeviceIntegrationProfileKey(ZigbeeManufacturerFingerprint $model, array $data): void
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
    private static function applyManufacturer(ZigbeeManufacturerFingerprint $model, array $data): void
    {
        if (empty($data[self::KEY_MANUFACTURER])) {
            return;
        }
        if (!is_string($data[self::KEY_MANUFACTURER])) {
            return;
        }
        $model->setManufacturer($data[self::KEY_MANUFACTURER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyModel(ZigbeeManufacturerFingerprint $model, array $data): void
    {
        if (empty($data[self::KEY_MODEL])) {
            return;
        }
        if (!is_string($data[self::KEY_MODEL])) {
            return;
        }
        $model->setModel($data[self::KEY_MODEL]);
    }
}
