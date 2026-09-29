<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocationRoomDetails implements LocationRoomDetailsInterface
{
    private ?RoomIndoorMapInterface $indoorMap = null;

    public function getIndoorMap(): ?RoomIndoorMapInterface
    {
        return $this->indoorMap;
    }

    public function setIndoorMap(?RoomIndoorMapInterface $value): LocationRoomDetailsInterface
    {
        $this->indoorMap = $value;

        return $this;
    }
}
