<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationRoom;
use ChristianBrown\SmartThings\Model\LocationRoomDetailsInterface;
use ChristianBrown\SmartThings\Model\LocationRoomInterface;

use function array_filter;
use function array_flip;
use function array_intersect_key;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class LocationRoomTransformer implements LocationRoomTransformerInterface
{
    private LocationRoomDetailsTransformerInterface $locationRoomDetailsTransformer;

    public function __construct(LocationRoomDetailsTransformerInterface $locationRoomDetailsTransformer)
    {
        $this->locationRoomDetailsTransformer = $locationRoomDetailsTransformer;
    }

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

        self::applyAllowed($room, $data);
        self::applyBackgroundImage($room, $data);
        self::applyCreated($room, $data);
        self::applyLastModified($room, $data);

        $this->applyDetails($room, $data);

        return $room;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAllowed(LocationRoom $model, array $data): void
    {
        if (!isset($data[self::KEY_ALLOWED])) {
            return;
        }
        if (!is_array($data[self::KEY_ALLOWED])) {
            return;
        }
        $model->setAllowed(array_values(array_filter($data[self::KEY_ALLOWED], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBackgroundImage(LocationRoom $model, array $data): void
    {
        if (empty($data[self::KEY_BACKGROUND_IMAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_BACKGROUND_IMAGE])) {
            return;
        }
        $model->setBackgroundImage($data[self::KEY_BACKGROUND_IMAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCreated(LocationRoom $model, array $data): void
    {
        if (empty($data[self::KEY_CREATED])) {
            return;
        }
        if (!is_string($data[self::KEY_CREATED])) {
            return;
        }
        $model->setCreated($data[self::KEY_CREATED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(LocationRoom $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->locationRoomDetailsTransformer->transform($data);
        self::copyIndoorMap($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLastModified(LocationRoom $model, array $data): void
    {
        if (empty($data[self::KEY_LAST_MODIFIED])) {
            return;
        }
        if (!is_string($data[self::KEY_LAST_MODIFIED])) {
            return;
        }
        $model->setLastModified($data[self::KEY_LAST_MODIFIED]);
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

    private static function copyIndoorMap(LocationRoom $model, LocationRoomDetailsInterface $details): void
    {
        $model->setIndoorMap($details->getIndoorMap());
    }
}
