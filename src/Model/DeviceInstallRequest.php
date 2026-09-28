<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceInstallRequest implements DeviceInstallRequestInterface
{
    private DeviceInstallAppInterface $app;
    private ?string $label = null;
    private string $locationId;
    private ?string $roomId = null;

    public function __construct(string $locationId, DeviceInstallAppInterface $app)
    {
        $this->locationId = $locationId;
        $this->app = $app;
    }

    public function getApp(): DeviceInstallAppInterface
    {
        return $this->app;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getRoomId(): ?string
    {
        return $this->roomId;
    }

    public function setLabel(?string $value): DeviceInstallRequestInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setRoomId(?string $value): DeviceInstallRequestInterface
    {
        $this->roomId = $value;

        return $this;
    }
}
