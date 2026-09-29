<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppReceiptInterface;

interface SchemaAppReceiptTransformerInterface
{
    public const string KEY_ENDPOINT_APP_ID = 'endpointAppId';
    public const string KEY_ST_CLIENT_ID = 'stClientId';
    public const string KEY_ST_CLIENT_SECRET = 'stClientSecret';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppReceiptInterface;
}
