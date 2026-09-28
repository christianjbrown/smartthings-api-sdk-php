<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\GenerateAppOauthRequestInterface;

interface GenerateAppOauthRequestSerializerInterface
{
    public const string KEY_CLIENT_NAME = 'clientName';
    public const string KEY_SCOPE = 'scope';

    /**
     * @return mixed[]
     */
    public function serialize(GenerateAppOauthRequestInterface $request): array;
}
