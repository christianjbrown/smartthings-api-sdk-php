<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateAppOauthRequestInterface;

interface UpdateAppOauthRequestSerializerInterface
{
    public const string KEY_CLIENT_NAME = 'clientName';
    public const string KEY_REDIRECT_URIS = 'redirectUris';
    public const string KEY_SCOPE = 'scope';

    /**
     * @return mixed[]
     */
    public function serialize(UpdateAppOauthRequestInterface $request): array;
}
