<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\HubDriverInstallRequestInterface;

interface HubDriverInstallRequestSerializerInterface
{
    public const string KEY_CHANNEL_ID = 'channelId';

    /**
     * @return mixed[]
     */
    public function serialize(HubDriverInstallRequestInterface $request): array;
}
