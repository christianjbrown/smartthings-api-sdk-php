<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ZigbeeDeviceDetails;
use ChristianBrown\SmartThings\Model\ZigbeeDeviceDetailsInterface;

use function is_bool;
use function is_string;

final class ZigbeeDeviceDetailsTransformer implements ZigbeeDeviceDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZigbeeDeviceDetailsInterface
    {
        $model = new ZigbeeDeviceDetails();

        self::applyEui($model, $data);
        self::applyNetworkId($model, $data);
        self::applyDriverId($model, $data);
        self::applyExecutingLocally($model, $data);
        self::applyHubId($model, $data);
        self::applyProvisioningState($model, $data);
        self::applyFingerprintType($model, $data);
        self::applyFingerprintId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDriverId(ZigbeeDeviceDetails $model, array $data): void
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
    private static function applyEui(ZigbeeDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_EUI])) {
            return;
        }
        if (!is_string($data[self::KEY_EUI])) {
            return;
        }
        $model->setEui($data[self::KEY_EUI]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExecutingLocally(ZigbeeDeviceDetails $model, array $data): void
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
    private static function applyFingerprintId(ZigbeeDeviceDetails $model, array $data): void
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
    private static function applyFingerprintType(ZigbeeDeviceDetails $model, array $data): void
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
    private static function applyHubId(ZigbeeDeviceDetails $model, array $data): void
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
    private static function applyNetworkId(ZigbeeDeviceDetails $model, array $data): void
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
    private static function applyProvisioningState(ZigbeeDeviceDetails $model, array $data): void
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
