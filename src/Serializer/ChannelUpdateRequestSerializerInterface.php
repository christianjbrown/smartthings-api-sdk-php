<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ChannelUpdateRequestInterface;

interface ChannelUpdateRequestSerializerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_NAME = 'name';
    public const string KEY_TERMS_OF_SERVICE_URL = 'termsOfServiceUrl';

    /**
     * @return mixed[]
     */
    public function serialize(ChannelUpdateRequestInterface $request): array;
}
