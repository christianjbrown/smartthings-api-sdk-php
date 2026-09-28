<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateDeviceRequestInterface;

interface UpdateDeviceRequestSerializerInterface
{
    public const string KEY_LABEL = 'label';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_ROOM_ID = 'roomId';

    /**
     * @return mixed[]
     */
    public function serialize(UpdateDeviceRequestInterface $request): array;
}
