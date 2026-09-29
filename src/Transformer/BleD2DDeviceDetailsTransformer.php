<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BleD2DDeviceDetails;
use ChristianBrown\SmartThings\Model\BleD2DDeviceDetailsInterface;

use function is_array;
use function is_string;

final class BleD2DDeviceDetailsTransformer implements BleD2DDeviceDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BleD2DDeviceDetailsInterface
    {
        $model = new BleD2DDeviceDetails();

        self::applyEncryptionKey($model, $data);
        self::applyCipher($model, $data);
        self::applyGattCipher($model, $data);
        self::applyAdvertisingId($model, $data);
        self::applyIdentifier($model, $data);
        self::applyConfigurationVersion($model, $data);
        self::applyConfigurationUrl($model, $data);
        self::applyBleDeviceType($model, $data);
        self::applyMetadata($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdvertisingId(BleD2DDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_ADVERTISING_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ADVERTISING_ID])) {
            return;
        }
        $model->setAdvertisingId($data[self::KEY_ADVERTISING_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBleDeviceType(BleD2DDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_BLE_DEVICE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_BLE_DEVICE_TYPE])) {
            return;
        }
        $model->setBleDeviceType($data[self::KEY_BLE_DEVICE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCipher(BleD2DDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_CIPHER])) {
            return;
        }
        if (!is_string($data[self::KEY_CIPHER])) {
            return;
        }
        $model->setCipher($data[self::KEY_CIPHER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConfigurationUrl(BleD2DDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_CONFIGURATION_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_CONFIGURATION_URL])) {
            return;
        }
        $model->setConfigurationUrl($data[self::KEY_CONFIGURATION_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConfigurationVersion(BleD2DDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_CONFIGURATION_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_CONFIGURATION_VERSION])) {
            return;
        }
        $model->setConfigurationVersion($data[self::KEY_CONFIGURATION_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEncryptionKey(BleD2DDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_ENCRYPTION_KEY])) {
            return;
        }
        if (!is_string($data[self::KEY_ENCRYPTION_KEY])) {
            return;
        }
        $model->setEncryptionKey($data[self::KEY_ENCRYPTION_KEY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGattCipher(BleD2DDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_GATT_CIPHER])) {
            return;
        }
        if (!is_string($data[self::KEY_GATT_CIPHER])) {
            return;
        }
        $model->setGattCipher($data[self::KEY_GATT_CIPHER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIdentifier(BleD2DDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_IDENTIFIER])) {
            return;
        }
        if (!is_string($data[self::KEY_IDENTIFIER])) {
            return;
        }
        $model->setIdentifier($data[self::KEY_IDENTIFIER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMetadata(BleD2DDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_METADATA])) {
            return;
        }
        if (!is_array($data[self::KEY_METADATA])) {
            return;
        }
        $model->setMetadata($data[self::KEY_METADATA]);
    }
}
