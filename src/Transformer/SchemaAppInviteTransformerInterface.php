<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteInterface;

interface SchemaAppInviteTransformerInterface
{
    public const string KEY_ACCEPT_URL = 'acceptUrl';
    public const string KEY_DECLINE_URL = 'declineUrl';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_EXPIRATION = 'expiration';
    public const string KEY_ID = 'id';
    public const string KEY_SCHEMA_APP_ID = 'schemaAppId';
    public const string KEY_SHORT_CODE = 'shortCode';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInviteInterface;
}
