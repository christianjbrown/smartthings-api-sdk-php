<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\RoomConfigInterface;

interface RoomConfigTransformerInterface
{
    public const string KEY_PERMISSIONS = 'permissions';
    public const string KEY_ROOM_ID = 'roomId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RoomConfigInterface;
}
