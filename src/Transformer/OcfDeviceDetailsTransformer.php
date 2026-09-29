<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\OcfDeviceDetails;
use ChristianBrown\SmartThings\Model\OcfDeviceDetailsInterface;

use function is_bool;
use function is_string;

final class OcfDeviceDetailsTransformer implements OcfDeviceDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OcfDeviceDetailsInterface
    {
        $model = new OcfDeviceDetails();

        self::applyOcfDeviceType($model, $data);
        self::applyName($model, $data);
        self::applySpecVersion($model, $data);
        self::applyVerticalDomainSpecVersion($model, $data);
        self::applyManufacturerName($model, $data);
        self::applyModelNumber($model, $data);
        self::applyPlatformVersion($model, $data);
        self::applyPlatformOS($model, $data);
        self::applyHwVersion($model, $data);
        self::applyFirmwareVersion($model, $data);
        self::applyVendorId($model, $data);
        self::applyVendorResourceClientServerVersion($model, $data);
        self::applyLocale($model, $data);
        self::applyLastSignupTime($model, $data);
        self::applyTransferCandidate($model, $data);
        self::applyAdditionalAuthCodeRequired($model, $data);
        self::applyModelCode($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdditionalAuthCodeRequired(OcfDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_ADDITIONAL_AUTH_CODE_REQUIRED])) {
            return;
        }
        if (!is_bool($data[self::KEY_ADDITIONAL_AUTH_CODE_REQUIRED])) {
            return;
        }
        $model->setAdditionalAuthCodeRequired($data[self::KEY_ADDITIONAL_AUTH_CODE_REQUIRED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFirmwareVersion(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_FIRMWARE_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_FIRMWARE_VERSION])) {
            return;
        }
        $model->setFirmwareVersion($data[self::KEY_FIRMWARE_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHwVersion(OcfDeviceDetails $model, array $data): void
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
    private static function applyLastSignupTime(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_LAST_SIGNUP_TIME])) {
            return;
        }
        if (!is_string($data[self::KEY_LAST_SIGNUP_TIME])) {
            return;
        }
        $model->setLastSignupTime($data[self::KEY_LAST_SIGNUP_TIME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocale(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_LOCALE])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCALE])) {
            return;
        }
        $model->setLocale($data[self::KEY_LOCALE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyManufacturerName(OcfDeviceDetails $model, array $data): void
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
    private static function applyModelCode(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_MODEL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_MODEL_CODE])) {
            return;
        }
        $model->setModelCode($data[self::KEY_MODEL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyModelNumber(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_MODEL_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_MODEL_NUMBER])) {
            return;
        }
        $model->setModelNumber($data[self::KEY_MODEL_NUMBER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $model->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOcfDeviceType(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_OCF_DEVICE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_OCF_DEVICE_TYPE])) {
            return;
        }
        $model->setOcfDeviceType($data[self::KEY_OCF_DEVICE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPlatformOS(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_PLATFORM_OS])) {
            return;
        }
        if (!is_string($data[self::KEY_PLATFORM_OS])) {
            return;
        }
        $model->setPlatformOS($data[self::KEY_PLATFORM_OS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPlatformVersion(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_PLATFORM_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_PLATFORM_VERSION])) {
            return;
        }
        $model->setPlatformVersion($data[self::KEY_PLATFORM_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySpecVersion(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_SPEC_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_SPEC_VERSION])) {
            return;
        }
        $model->setSpecVersion($data[self::KEY_SPEC_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTransferCandidate(OcfDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_TRANSFER_CANDIDATE])) {
            return;
        }
        if (!is_bool($data[self::KEY_TRANSFER_CANDIDATE])) {
            return;
        }
        $model->setTransferCandidate($data[self::KEY_TRANSFER_CANDIDATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVendorId(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_VENDOR_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_VENDOR_ID])) {
            return;
        }
        $model->setVendorId($data[self::KEY_VENDOR_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVendorResourceClientServerVersion(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_VENDOR_RESOURCE_CLIENT_SERVER_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_VENDOR_RESOURCE_CLIENT_SERVER_VERSION])) {
            return;
        }
        $model->setVendorResourceClientServerVersion($data[self::KEY_VENDOR_RESOURCE_CLIENT_SERVER_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVerticalDomainSpecVersion(OcfDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_VERTICAL_DOMAIN_SPEC_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_VERTICAL_DOMAIN_SPEC_VERSION])) {
            return;
        }
        $model->setVerticalDomainSpecVersion($data[self::KEY_VERTICAL_DOMAIN_SPEC_VERSION]);
    }
}
