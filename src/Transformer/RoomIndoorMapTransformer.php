<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\RoomIndoorMap;
use ChristianBrown\SmartThings\Model\RoomIndoorMapInterface;

use function is_string;

final class RoomIndoorMapTransformer implements RoomIndoorMapTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RoomIndoorMapInterface
    {
        $model = new RoomIndoorMap();

        self::applyMapRoomId($model, $data);
        self::applyColor($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyColor(RoomIndoorMap $model, array $data): void
    {
        if (empty($data[self::KEY_COLOR])) {
            return;
        }
        if (!is_string($data[self::KEY_COLOR])) {
            return;
        }
        $model->setColor($data[self::KEY_COLOR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMapRoomId(RoomIndoorMap $model, array $data): void
    {
        if (empty($data[self::KEY_MAP_ROOM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_MAP_ROOM_ID])) {
            return;
        }
        $model->setMapRoomId($data[self::KEY_MAP_ROOM_ID]);
    }
}
