<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateDeviceRequest implements UpdateDeviceRequestInterface
{
    /**
     * @var null|array<int, UpdateDeviceComponentInterface>
     */
    private ?array $components = null;
    private ?IndoorMapInterface $indoorMap = null;
    private ?string $label = null;
    private ?string $locationId = null;
    private ?string $roomId = null;

    /**
     * @return null|array<int, UpdateDeviceComponentInterface>
     */
    public function getComponents(): ?array
    {
        return $this->components;
    }

    public function getIndoorMap(): ?IndoorMapInterface
    {
        return $this->indoorMap;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getRoomId(): ?string
    {
        return $this->roomId;
    }

    /**
     * @param null|array<int, UpdateDeviceComponentInterface> $value
     */
    public function setComponents(?array $value): UpdateDeviceRequestInterface
    {
        $this->components = $value;

        return $this;
    }

    public function setIndoorMap(?IndoorMapInterface $value): UpdateDeviceRequestInterface
    {
        $this->indoorMap = $value;

        return $this;
    }

    public function setLabel(?string $value): UpdateDeviceRequestInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setLocationId(?string $value): UpdateDeviceRequestInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setRoomId(?string $value): UpdateDeviceRequestInterface
    {
        $this->roomId = $value;

        return $this;
    }
}
