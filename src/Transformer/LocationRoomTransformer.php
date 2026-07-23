<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationRoom;
use ChristianBrown\SmartThings\Model\LocationRoomInterface;

use function is_string;
use function sprintf;

final class LocationRoomTransformer implements LocationRoomTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationRoomInterface
    {
        if (empty($data[self::KEY_ROOM_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ROOM_ID));
        }
        if (!is_string($data[self::KEY_ROOM_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ROOM_ID));
        }
        $room = new LocationRoom($data[self::KEY_ROOM_ID]);

        self::applyLocationId($room, $data);
        self::applyName($room, $data);

        return $room;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(LocationRoom $room, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $room->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(LocationRoom $room, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $room->setName($data[self::KEY_NAME]);
    }
}
