<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaPageInterface;

interface SchemaPageTransformerInterface
{
    public const string KEY_APP_NAME = 'appName';
    public const string KEY_ISA_ID = 'isaId';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_O_AUTH_LINK = 'oAuthLink';
    public const string KEY_PAGE_TYPE = 'pageType';
    public const string KEY_PARTNER_NAME = 'partnerName';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaPageInterface;
}
