<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DthDeviceDetails;
use ChristianBrown\SmartThings\Model\DthDeviceDetailsInterface;

use function is_bool;
use function is_string;

final class DthDeviceDetailsTransformer implements DthDeviceDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DthDeviceDetailsInterface
    {
        $model = new DthDeviceDetails(self::requireCompletedSetup($data), self::requireDeviceTypeId($data), self::requireDeviceTypeName($data));

        self::applyDeviceNetworkType($model, $data);
        self::applyExecutingLocally($model, $data);
        self::applyHubId($model, $data);
        self::applyInstalledGroovyAppId($model, $data);
        self::applyNetworkId($model, $data);
        self::applyNetworkSecurityLevel($model, $data);
        self::applyFingerprintType($model, $data);
        self::applyFingerprintId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceNetworkType(DthDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_NETWORK_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_NETWORK_TYPE])) {
            return;
        }
        $model->setDeviceNetworkType($data[self::KEY_DEVICE_NETWORK_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExecutingLocally(DthDeviceDetails $model, array $data): void
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
    private static function applyFingerprintId(DthDeviceDetails $model, array $data): void
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
    private static function applyFingerprintType(DthDeviceDetails $model, array $data): void
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
    private static function applyHubId(DthDeviceDetails $model, array $data): void
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
    private static function applyInstalledGroovyAppId(DthDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_GROOVY_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_GROOVY_APP_ID])) {
            return;
        }
        $model->setInstalledGroovyAppId($data[self::KEY_INSTALLED_GROOVY_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNetworkId(DthDeviceDetails $model, array $data): void
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
    private static function applyNetworkSecurityLevel(DthDeviceDetails $model, array $data): void
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
     * @param mixed[] $data
     */
    private static function requireCompletedSetup(array $data): ?bool
    {
        if (!isset($data[self::KEY_COMPLETED_SETUP])) {
            return null;
        }
        if (!is_bool($data[self::KEY_COMPLETED_SETUP])) {
            return null;
        }

        return $data[self::KEY_COMPLETED_SETUP];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDeviceTypeId(array $data): ?string
    {
        if (empty($data[self::KEY_DEVICE_TYPE_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_DEVICE_TYPE_ID])) {
            return null;
        }

        return $data[self::KEY_DEVICE_TYPE_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDeviceTypeName(array $data): ?string
    {
        if (empty($data[self::KEY_DEVICE_TYPE_NAME])) {
            return null;
        }
        if (!is_string($data[self::KEY_DEVICE_TYPE_NAME])) {
            return null;
        }

        return $data[self::KEY_DEVICE_TYPE_NAME];
    }
}
