<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocationRoomDetailsInterface
{
    public function getIndoorMap(): ?RoomIndoorMapInterface;

    public function setIndoorMap(?RoomIndoorMapInterface $value): self;
}
