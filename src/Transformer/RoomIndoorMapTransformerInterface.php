<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\RoomIndoorMapInterface;

interface RoomIndoorMapTransformerInterface
{
    public const string KEY_COLOR = 'color';
    public const string KEY_MAP_ROOM_ID = 'mapRoomId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RoomIndoorMapInterface;
}
