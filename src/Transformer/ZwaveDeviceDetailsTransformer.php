<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ZwaveDeviceDetails;
use ChristianBrown\SmartThings\Model\ZwaveDeviceDetailsInterface;

use function is_bool;
use function is_int;
use function is_string;

final class ZwaveDeviceDetailsTransformer implements ZwaveDeviceDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZwaveDeviceDetailsInterface
    {
        $model = new ZwaveDeviceDetails();

        self::applyNetworkId($model, $data);
        self::applyDriverId($model, $data);
        self::applyExecutingLocally($model, $data);
        self::applyHubId($model, $data);
        self::applyNetworkSecurityLevel($model, $data);
        self::applyProvisioningState($model, $data);
        self::applyManufacturerId($model, $data);
        self::applyProductType($model, $data);
        self::applyProductId($model, $data);
        self::applyFingerprintType($model, $data);
        self::applyFingerprintId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDriverId(ZwaveDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_DRIVER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_DRIVER_ID])) {
            return;
        }
        $model->setDriverId($data[self::KEY_DRIVER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExecutingLocally(ZwaveDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_EXECUTING_LOCALLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_EXECUTING_LOCALLY])) {
            return;
        }
        $model->setExecutingLocally($data[self::KEY_EXECUTING_LOCALLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFingerprintId(ZwaveDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_FINGERPRINT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_FINGERPRINT_ID])) {
            return;
        }
        $model->setFingerprintId($data[self::KEY_FINGERPRINT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFingerprintType(ZwaveDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_FINGERPRINT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_FINGERPRINT_TYPE])) {
            return;
        }
        $model->setFingerprintType($data[self::KEY_FINGERPRINT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHubId(ZwaveDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_HUB_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_HUB_ID])) {
            return;
        }
        $model->setHubId($data[self::KEY_HUB_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyManufacturerId(ZwaveDeviceDetails $model, array $data): void
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
    private static function applyNetworkId(ZwaveDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_NETWORK_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_NETWORK_ID])) {
            return;
        }
        $model->setNetworkId($data[self::KEY_NETWORK_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNetworkSecurityLevel(ZwaveDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_NETWORK_SECURITY_LEVEL])) {
            return;
        }
        if (!is_string($data[self::KEY_NETWORK_SECURITY_LEVEL])) {
            return;
        }
        $model->setNetworkSecurityLevel($data[self::KEY_NETWORK_SECURITY_LEVEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProductId(ZwaveDeviceDetails $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private static function applyProductType(ZwaveDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_PRODUCT_TYPE])) {
            return;
        }
        if (!is_int($data[self::KEY_PRODUCT_TYPE])) {
            return;
        }
        $model->setProductType($data[self::KEY_PRODUCT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProvisioningState(ZwaveDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_PROVISIONING_STATE])) {
            return;
        }
        if (!is_string($data[self::KEY_PROVISIONING_STATE])) {
            return;
        }
        $model->setProvisioningState($data[self::KEY_PROVISIONING_STATE]);
    }
}
