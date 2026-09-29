<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface GroupDeviceDetailsInterface
{
    /**
     * @return null|array<int, GroupDeviceDetailsDevicesItemInterface>
     */
    public function getDevices(): ?array;

    public function getGroupName(): ?string;

    public function getGroupType(): ?string;

    /**
     * @param null|array<int, GroupDeviceDetailsDevicesItemInterface> $value
     */
    public function setDevices(?array $value): self;

    public function setGroupName(?string $value): self;

    public function setGroupType(?string $value): self;
}
