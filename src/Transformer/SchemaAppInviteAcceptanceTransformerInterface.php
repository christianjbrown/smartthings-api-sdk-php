<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteAcceptanceInterface;

interface SchemaAppInviteAcceptanceTransformerInterface
{
    public const string KEY_SCHEMA_APP_ID = 'schemaAppId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInviteAcceptanceInterface;
}
