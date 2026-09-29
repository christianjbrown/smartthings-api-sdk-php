<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface RoomIndoorMapInterface
{
    public function getColor(): ?string;

    public function getMapRoomId(): ?string;

    public function setColor(?string $value): self;

    public function setMapRoomId(?string $value): self;
}
