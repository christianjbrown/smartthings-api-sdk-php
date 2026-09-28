<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CreateAppResponseInterface;

interface CreateAppResponseTransformerInterface
{
    public const string KEY_APP = 'app';
    public const string KEY_OAUTH_CLIENT_ID = 'oauthClientId';
    public const string KEY_OAUTH_CLIENT_SECRET = 'oauthClientSecret';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CreateAppResponseInterface;
}
