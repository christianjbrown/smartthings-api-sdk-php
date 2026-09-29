<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;

interface InstalledSchemaAppTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_DEVICES, self::KEY_VIPER_APP_LINKS];
    public const string KEY_APP_NAME = 'appName';
    public const string KEY_DEVICES = 'devices';
    public const string KEY_DRIVER_ID = 'driverId';
    public const string KEY_ENDPOINT_APP_ID = 'endpointAppId';
    public const string KEY_ICON = 'icon';
    public const string KEY_ICON2X = 'icon2x';
    public const string KEY_ICON3X = 'icon3x';
    public const string KEY_ISA_ID = 'isaId';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_O_AUTH_LINK = 'oAuthLink';
    public const string KEY_PAGE_TYPE = 'pageType';
    public const string KEY_PARTNER_NAME = 'partnerName';
    public const string KEY_PARTNER_STCONNECTION = 'partnerSTConnection';
    public const string KEY_ST_EULA_FILE_NAME = 'stEulaFileName';
    public const string KEY_ST_EULA_LOCKSMITH_KEY = 'stEulaLocksmithKey';
    public const string KEY_VIPER_APP_LINKS = 'viperAppLinks';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledSchemaAppInterface;
}
