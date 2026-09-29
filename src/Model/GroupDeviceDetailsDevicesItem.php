<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class GroupDeviceDetailsDevicesItem implements GroupDeviceDetailsDevicesItemInterface
{
    /**
     * @var null|array<int, GroupDeviceDetailsDevicesItemComponentsItemInterface>
     */
    private ?array $components = null;
    private string $deviceId;

    public function __construct(string $deviceId)
    {
        $this->deviceId = $deviceId;
    }

    /**
     * @return null|array<int, GroupDeviceDetailsDevicesItemComponentsItemInterface>
     */
    public function getComponents(): ?array
    {
        return $this->components;
    }

    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    /**
     * @param null|array<int, GroupDeviceDetailsDevicesItemComponentsItemInterface> $value
     */
    public function setComponents(?array $value): GroupDeviceDetailsDevicesItemInterface
    {
        $this->components = $value;

        return $this;
    }
}
