<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationRoomInterface;

interface LocationRoomTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_INDOOR_MAP];
    public const string KEY_ALLOWED = 'allowed';
    public const string KEY_BACKGROUND_IMAGE = 'backgroundImage';
    public const string KEY_CREATED = 'created';
    public const string KEY_INDOOR_MAP = 'indoorMap';
    public const string KEY_LAST_MODIFIED = 'lastModified';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_NAME = 'name';
    public const string KEY_ROOM_ID = 'roomId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationRoomInterface;
}
