<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ViperDeviceDetails;
use ChristianBrown\SmartThings\Model\ViperDeviceDetailsInterface;

use function is_string;

final class ViperDeviceDetailsTransformer implements ViperDeviceDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ViperDeviceDetailsInterface
    {
        $model = new ViperDeviceDetails();

        self::applyUniqueIdentifier($model, $data);
        self::applyManufacturerName($model, $data);
        self::applyModelName($model, $data);
        self::applySwVersion($model, $data);
        self::applyHwVersion($model, $data);
        self::applyEndpointAppId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEndpointAppId(ViperDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_ENDPOINT_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ENDPOINT_APP_ID])) {
            return;
        }
        $model->setEndpointAppId($data[self::KEY_ENDPOINT_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHwVersion(ViperDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_HW_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_HW_VERSION])) {
            return;
        }
        $model->setHwVersion($data[self::KEY_HW_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyManufacturerName(ViperDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        $model->setManufacturerName($data[self::KEY_MANUFACTURER_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyModelName(ViperDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_MODEL_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_MODEL_NAME])) {
            return;
        }
        $model->setModelName($data[self::KEY_MODEL_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySwVersion(ViperDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_SW_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_SW_VERSION])) {
            return;
        }
        $model->setSwVersion($data[self::KEY_SW_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUniqueIdentifier(ViperDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_UNIQUE_IDENTIFIER])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIQUE_IDENTIFIER])) {
            return;
        }
        $model->setUniqueIdentifier($data[self::KEY_UNIQUE_IDENTIFIER]);
    }
}
