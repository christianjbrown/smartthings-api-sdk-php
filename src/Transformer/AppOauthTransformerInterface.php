<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppOauthInterface;

interface AppOauthTransformerInterface
{
    public const string KEY_CLIENT_NAME = 'clientName';
    public const string KEY_REDIRECT_URIS = 'redirectUris';
    public const string KEY_SCOPE = 'scope';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppOauthInterface;
}
