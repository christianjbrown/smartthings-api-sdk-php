<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface RoomConfigInterface
{
    /**
     * @return array<int, string>
     */
    public function getPermissions(): array;

    public function getRoomId(): ?string;

    /**
     * @param array<int, string> $value
     */
    public function setPermissions(array $value): self;

    public function setRoomId(?string $value): self;
}
