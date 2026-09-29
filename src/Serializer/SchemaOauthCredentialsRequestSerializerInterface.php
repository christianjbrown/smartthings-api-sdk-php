<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SchemaOauthCredentialsRequestInterface;

interface SchemaOauthCredentialsRequestSerializerInterface
{
    public const string KEY_ENDPOINT_APP_ID = 'endpointAppId';

    /**
     * @return mixed[]
     */
    public function serialize(SchemaOauthCredentialsRequestInterface $request): array;
}
