<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\OcfDeviceDetailsInterface;

interface OcfDeviceDetailsTransformerInterface
{
    public const string KEY_ADDITIONAL_AUTH_CODE_REQUIRED = 'additionalAuthCodeRequired';
    public const string KEY_FIRMWARE_VERSION = 'firmwareVersion';
    public const string KEY_HW_VERSION = 'hwVersion';
    public const string KEY_LAST_SIGNUP_TIME = 'lastSignupTime';
    public const string KEY_LOCALE = 'locale';
    public const string KEY_MANUFACTURER_NAME = 'manufacturerName';
    public const string KEY_MODEL_CODE = 'modelCode';
    public const string KEY_MODEL_NUMBER = 'modelNumber';
    public const string KEY_NAME = 'name';
    public const string KEY_OCF_DEVICE_TYPE = 'ocfDeviceType';
    public const string KEY_PLATFORM_OS = 'platformOS';
    public const string KEY_PLATFORM_VERSION = 'platformVersion';
    public const string KEY_SPEC_VERSION = 'specVersion';
    public const string KEY_TRANSFER_CANDIDATE = 'transferCandidate';
    public const string KEY_VENDOR_ID = 'vendorId';
    public const string KEY_VENDOR_RESOURCE_CLIENT_SERVER_VERSION = 'vendorResourceClientServerVersion';
    public const string KEY_VERTICAL_DOMAIN_SPEC_VERSION = 'verticalDomainSpecVersion';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OcfDeviceDetailsInterface;
}
