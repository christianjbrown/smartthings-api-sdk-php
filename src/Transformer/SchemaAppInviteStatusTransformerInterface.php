<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteStatusInterface;

interface SchemaAppInviteStatusTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_EXPIRATION = 'expiration';
    public const string KEY_IS_ACCEPTED = 'isAccepted';
    public const string KEY_SCHEMA_APP_ID = 'schemaAppId';
    public const string KEY_SHORT_CODE = 'shortCode';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInviteStatusInterface;
}
