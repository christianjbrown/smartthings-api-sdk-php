<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInterface;

interface SchemaAppTransformerInterface
{
    public const string KEY_APP_NAME = 'appName';
    public const string KEY_CERTIFICATION_STATUS = 'certificationStatus';
    public const string KEY_ENDPOINT_APP_ID = 'endpointAppId';
    public const string KEY_PARTNER_NAME = 'partnerName';
    public const string KEY_ST_CLIENT_ID = 'stClientId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInterface;
}
