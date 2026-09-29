<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\EdgeChildDeviceDetails;
use ChristianBrown\SmartThings\Model\EdgeChildDeviceDetailsInterface;

use function is_bool;
use function is_string;

final class EdgeChildDeviceDetailsTransformer implements EdgeChildDeviceDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EdgeChildDeviceDetailsInterface
    {
        $model = new EdgeChildDeviceDetails();

        self::applyDriverId($model, $data);
        self::applyHubId($model, $data);
        self::applyProvisioningState($model, $data);
        self::applyNetworkId($model, $data);
        self::applyExecutingLocally($model, $data);
        self::applyParentAssignedChildKey($model, $data);
        self::applyFingerprintType($model, $data);
        self::applyFingerprintId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDriverId(EdgeChildDeviceDetails $model, array $data): void
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
    private static function applyExecutingLocally(EdgeChildDeviceDetails $model, array $data): void
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
    private static function applyFingerprintId(EdgeChildDeviceDetails $model, array $data): void
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
    private static function applyFingerprintType(EdgeChildDeviceDetails $model, array $data): void
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
    private static function applyHubId(EdgeChildDeviceDetails $model, array $data): void
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
    private static function applyNetworkId(EdgeChildDeviceDetails $model, array $data): void
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
    private static function applyParentAssignedChildKey(EdgeChildDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_PARENT_ASSIGNED_CHILD_KEY])) {
            return;
        }
        if (!is_string($data[self::KEY_PARENT_ASSIGNED_CHILD_KEY])) {
            return;
        }
        $model->setParentAssignedChildKey($data[self::KEY_PARENT_ASSIGNED_CHILD_KEY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProvisioningState(EdgeChildDeviceDetails $model, array $data): void
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
