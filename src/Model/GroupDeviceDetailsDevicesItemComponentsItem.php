<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class GroupDeviceDetailsDevicesItemComponentsItem implements GroupDeviceDetailsDevicesItemComponentsItemInterface
{
    private ?string $id = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $value): GroupDeviceDetailsDevicesItemComponentsItemInterface
    {
        $this->id = $value;

        return $this;
    }
}
