<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface GroupDeviceDetailsDevicesItemInterface
{
    /**
     * @return null|array<int, GroupDeviceDetailsDevicesItemComponentsItemInterface>
     */
    public function getComponents(): ?array;

    public function getDeviceId(): ?string;

    /**
     * @param null|array<int, GroupDeviceDetailsDevicesItemComponentsItemInterface> $value
     */
    public function setComponents(?array $value): self;
}
