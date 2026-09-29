<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class GroupDeviceDetails implements GroupDeviceDetailsInterface
{
    /**
     * @var null|array<int, GroupDeviceDetailsDevicesItemInterface>
     */
    private ?array $devices = null;
    private ?string $groupName = null;
    private ?string $groupType = null;

    /**
     * @return null|array<int, GroupDeviceDetailsDevicesItemInterface>
     */
    public function getDevices(): ?array
    {
        return $this->devices;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function getGroupType(): ?string
    {
        return $this->groupType;
    }

    /**
     * @param null|array<int, GroupDeviceDetailsDevicesItemInterface> $value
     */
    public function setDevices(?array $value): GroupDeviceDetailsInterface
    {
        $this->devices = $value;

        return $this;
    }

    public function setGroupName(?string $value): GroupDeviceDetailsInterface
    {
        $this->groupName = $value;

        return $this;
    }

    public function setGroupType(?string $value): GroupDeviceDetailsInterface
    {
        $this->groupType = $value;

        return $this;
    }
}
