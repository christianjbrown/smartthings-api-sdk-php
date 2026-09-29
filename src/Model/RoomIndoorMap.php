<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class RoomIndoorMap implements RoomIndoorMapInterface
{
    private ?string $color = null;
    private ?string $mapRoomId = null;

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getMapRoomId(): ?string
    {
        return $this->mapRoomId;
    }

    public function setColor(?string $value): RoomIndoorMapInterface
    {
        $this->color = $value;

        return $this;
    }

    public function setMapRoomId(?string $value): RoomIndoorMapInterface
    {
        $this->mapRoomId = $value;

        return $this;
    }
}
