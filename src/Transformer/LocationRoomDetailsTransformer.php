<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationRoomDetails;
use ChristianBrown\SmartThings\Model\LocationRoomDetailsInterface;

use function is_array;

final class LocationRoomDetailsTransformer implements LocationRoomDetailsTransformerInterface
{
    private RoomIndoorMapTransformerInterface $roomIndoorMapTransformer;

    public function __construct(RoomIndoorMapTransformerInterface $roomIndoorMapTransformer)
    {
        $this->roomIndoorMapTransformer = $roomIndoorMapTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationRoomDetailsInterface
    {
        $model = new LocationRoomDetails();

        $this->applyIndoorMap($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyIndoorMap(LocationRoomDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_INDOOR_MAP])) {
            return;
        }
        if (!is_array($data[self::KEY_INDOOR_MAP])) {
            return;
        }
        $model->setIndoorMap($this->roomIndoorMapTransformer->transform($data[self::KEY_INDOOR_MAP]));
    }
}
