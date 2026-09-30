<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\UserSchemaAppsInterface;

interface UserSchemaAppsTransformerInterface
{
    public const string KEY_ENDPOINT_APPS = 'endpointApps';
    public const string KEY_USER_ID = 'userId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): UserSchemaAppsInterface;
}
