<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ChannelCreateRequestInterface;

interface ChannelCreateRequestSerializerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_NAME = 'name';
    public const string KEY_TERMS_OF_SERVICE_URL = 'termsOfServiceUrl';
    public const string KEY_TYPE = 'type';

    /**
     * @return mixed[]
     */
    public function serialize(ChannelCreateRequestInterface $request): array;
}
