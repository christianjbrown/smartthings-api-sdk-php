<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteRequestInterface;

interface SchemaAppInviteRequestSerializerInterface
{
    public const string KEY_ACCEPT_LIMIT = 'acceptLimit';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_SCHEMA_APP_ID = 'schemaAppId';

    /**
     * @return mixed[]
     */
    public function serialize(SchemaAppInviteRequestInterface $request): array;
}
