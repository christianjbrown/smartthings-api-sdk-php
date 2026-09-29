<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DthDeviceDetailsInterface;

interface DthDeviceDetailsTransformerInterface
{
    public const string KEY_COMPLETED_SETUP = 'completedSetup';
    public const string KEY_DEVICE_NETWORK_TYPE = 'deviceNetworkType';
    public const string KEY_DEVICE_TYPE_ID = 'deviceTypeId';
    public const string KEY_DEVICE_TYPE_NAME = 'deviceTypeName';
    public const string KEY_EXECUTING_LOCALLY = 'executingLocally';
    public const string KEY_FINGERPRINT_ID = 'fingerprintId';
    public const string KEY_FINGERPRINT_TYPE = 'fingerprintType';
    public const string KEY_HUB_ID = 'hubId';
    public const string KEY_INSTALLED_GROOVY_APP_ID = 'installedGroovyAppId';
    public const string KEY_NETWORK_ID = 'networkId';
    public const string KEY_NETWORK_SECURITY_LEVEL = 'networkSecurityLevel';
    public const string UNEXPECTED_BOOL_SPRINTF = '%s not set or not a boolean';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DthDeviceDetailsInterface;
}
