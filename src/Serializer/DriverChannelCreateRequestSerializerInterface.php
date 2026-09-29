<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DriverChannelCreateRequestInterface;

interface DriverChannelCreateRequestSerializerInterface
{
    public const string KEY_DRIVER_ID = 'driverId';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(DriverChannelCreateRequestInterface $request): array;
}
