<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class RoomConfig implements RoomConfigInterface
{
    /**
     * @var array<int, string>
     */
    private array $permissions = [];
    private ?string $roomId = null;

    /**
     * @return array<int, string>
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function getRoomId(): ?string
    {
        return $this->roomId;
    }

    /**
     * @param array<int, string> $value
     */
    public function setPermissions(array $value): RoomConfigInterface
    {
        $this->permissions = $value;

        return $this;
    }

    public function setRoomId(?string $value): RoomConfigInterface
    {
        $this->roomId = $value;

        return $this;
    }
}
