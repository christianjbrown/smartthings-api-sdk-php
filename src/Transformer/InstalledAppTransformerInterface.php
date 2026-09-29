<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppInterface;

interface InstalledAppTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_OWNER, self::KEY_NOTICES, self::KEY_UI, self::KEY_ICON_IMAGE];
    public const string KEY_ALLOWED = 'allowed';
    public const string KEY_APP_ID = 'appId';
    public const string KEY_CLASSIFICATIONS = 'classifications';
    public const string KEY_CREATED_DATE = 'createdDate';
    public const string KEY_DISPLAY_NAME = 'displayName';
    public const string KEY_ICON_IMAGE = 'iconImage';
    public const string KEY_INSTALLED_APP_ID = 'installedAppId';
    public const string KEY_INSTALLED_APP_STATUS = 'installedAppStatus';
    public const string KEY_INSTALLED_APP_TYPE = 'installedAppType';
    public const string KEY_LAST_UPDATED_DATE = 'lastUpdatedDate';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_NOTICES = 'notices';
    public const string KEY_OWNER = 'owner';
    public const string KEY_PRINCIPAL_TYPE = 'principalType';
    public const string KEY_REFERENCE_ID = 'referenceId';
    public const string KEY_RESTRICTION_TIER = 'restrictionTier';
    public const string KEY_SINGLE_INSTANCE = 'singleInstance';
    public const string KEY_UI = 'ui';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppInterface;
}
