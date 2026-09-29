<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocationRoom implements LocationRoomInterface
{
    /**
     * @var array<int, string>
     */
    private array $allowed = [];
    private ?string $backgroundImage = null;
    private ?string $created = null;
    private ?RoomIndoorMapInterface $indoorMap = null;
    private ?string $lastModified = null;
    private ?string $locationId = null;
    private ?string $name = null;
    private string $roomId;

    public function __construct(string $roomId)
    {
        $this->roomId = $roomId;
    }

    /**
     * @return array<int, string>
     */
    public function getAllowed(): array
    {
        return $this->allowed;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->backgroundImage;
    }

    public function getCreated(): ?string
    {
        return $this->created;
    }

    public function getIndoorMap(): ?RoomIndoorMapInterface
    {
        return $this->indoorMap;
    }

    public function getLastModified(): ?string
    {
        return $this->lastModified;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getRoomId(): string
    {
        return $this->roomId;
    }

    /**
     * @param array<int, string> $value
     */
    public function setAllowed(array $value): LocationRoomInterface
    {
        $this->allowed = $value;

        return $this;
    }

    public function setBackgroundImage(?string $value): LocationRoomInterface
    {
        $this->backgroundImage = $value;

        return $this;
    }

    public function setCreated(?string $value): LocationRoomInterface
    {
        $this->created = $value;

        return $this;
    }

    public function setIndoorMap(?RoomIndoorMapInterface $value): LocationRoomInterface
    {
        $this->indoorMap = $value;

        return $this;
    }

    public function setLastModified(?string $value): LocationRoomInterface
    {
        $this->lastModified = $value;

        return $this;
    }

    public function setLocationId(?string $value): LocationRoomInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setName(?string $value): LocationRoomInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setRoomId(string $value): LocationRoomInterface
    {
        $this->roomId = $value;

        return $this;
    }
}
