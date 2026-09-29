<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppInterface;

interface AppTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_ICON_IMAGE, self::KEY_OWNER, self::KEY_LAMBDA_SMART_APP, self::KEY_WEBHOOK_SMART_APP, self::KEY_UI];
    public const string KEY_APP_ID = 'appId';
    public const string KEY_APP_NAME = 'appName';
    public const string KEY_APP_TYPE = 'appType';
    public const string KEY_CLASSIFICATIONS = 'classifications';
    public const string KEY_CREATED_DATE = 'createdDate';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_DISPLAY_NAME = 'displayName';
    public const string KEY_ICON_IMAGE = 'iconImage';
    public const string KEY_INSTALL_METADATA = 'installMetadata';
    public const string KEY_LAMBDA_SMART_APP = 'lambdaSmartApp';
    public const string KEY_LAST_UPDATED_DATE = 'lastUpdatedDate';
    public const string KEY_OWNER = 'owner';
    public const string KEY_PRINCIPAL_TYPE = 'principalType';
    public const string KEY_SINGLE_INSTANCE = 'singleInstance';
    public const string KEY_UI = 'ui';
    public const string KEY_WEBHOOK_SMART_APP = 'webhookSmartApp';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppInterface;
}
