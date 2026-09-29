<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInterface;

interface SchemaAppTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_VIPER_APP_LINKS];
    public const string KEY_APP_NAME = 'appName';
    public const string KEY_CERTIFICATION_STATUS = 'certificationStatus';
    public const string KEY_ENDPOINT_APP_ID = 'endpointAppId';
    public const string KEY_HOSTING_TYPE = 'hostingType';
    public const string KEY_ICON = 'icon';
    public const string KEY_ICON2X = 'icon2x';
    public const string KEY_ICON3X = 'icon3x';
    public const string KEY_LAMBDA_ARN = 'lambdaArn';
    public const string KEY_LAMBDA_ARN_AP = 'lambdaArnAP';
    public const string KEY_LAMBDA_ARN_CN = 'lambdaArnCN';
    public const string KEY_LAMBDA_ARN_EU = 'lambdaArnEU';
    public const string KEY_O_AUTH_AUTHORIZATION_URL = 'oAuthAuthorizationUrl';
    public const string KEY_O_AUTH_CLIENT_ID = 'oAuthClientId';
    public const string KEY_O_AUTH_CLIENT_SECRET = 'oAuthClientSecret';
    public const string KEY_O_AUTH_SCOPE = 'oAuthScope';
    public const string KEY_O_AUTH_TOKEN_URL = 'oAuthTokenUrl';
    public const string KEY_ORGANIZATION_ID = 'organizationId';
    public const string KEY_PARTNER_NAME = 'partnerName';
    public const string KEY_SCHEMA_TYPE = 'schemaType';
    public const string KEY_ST_CLIENT_ID = 'stClientId';
    public const string KEY_USER_EMAIL = 'userEmail';
    public const string KEY_USER_ID = 'userId';
    public const string KEY_VIPER_APP_LINKS = 'viperAppLinks';
    public const string KEY_WEBHOOK_URL = 'webhookUrl';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInterface;
}
