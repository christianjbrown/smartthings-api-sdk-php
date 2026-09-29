<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DriverChannelUpdateRequestInterface;

interface DriverChannelUpdateRequestSerializerInterface
{
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(DriverChannelUpdateRequestInterface $request): array;
}
