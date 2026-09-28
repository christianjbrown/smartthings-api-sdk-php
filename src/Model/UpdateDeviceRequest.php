<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateDeviceRequest implements UpdateDeviceRequestInterface
{
    private ?string $label = null;
    private ?string $locationId = null;
    private ?string $roomId = null;

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
